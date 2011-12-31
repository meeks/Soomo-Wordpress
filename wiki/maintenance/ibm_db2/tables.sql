-- DB2

-- SQL to create the initial tables for the MediaWiki database.
-- This is read and executed by the install script; you should
-- not have to run it by itself unless doing a manual install.
-- This is the IBM DB2 version.
-- For information about each table, please see the notes in maintenance/tables.sql


CREATE TABLE user (
  user_id					BIGINT PRIMARY KEY GENERATED BY DEFAULT AS IDENTITY (START WITH 0),
  user_name                 VARCHAR(255)     NOT NULL  UNIQUE,
  user_real_name            VARCHAR(255),
  user_password             VARCHAR(1024),
  user_newpassword          VARCHAR(1024),
  user_newpass_time         TIMESTAMP(3),
  user_token                VARCHAR(255),
  user_email                VARCHAR(1024),
  user_email_token          VARCHAR(255),
  user_email_token_expires  TIMESTAMP(3),
  user_email_authenticated  TIMESTAMP(3),
  -- obsolete, replace by user_properties table
  user_options              CLOB(64K) INLINE LENGTH 4096,
  user_touched              TIMESTAMP(3),
  user_registration         TIMESTAMP(3),
  user_editcount            INTEGER
);
CREATE INDEX user_email_token_idx ON user (user_email_token);
--leonsp:
CREATE UNIQUE INDEX user_include_idx
	ON user(user_id)
	INCLUDE (user_name, user_real_name, user_password, user_newpassword, user_newpass_time, user_token,
		user_email, user_email_token, user_email_token_expires, user_email_authenticated,
		user_touched, user_registration, user_editcount);

-- Create a dummy user to satisfy fk contraints especially with revisions
INSERT INTO user(
user_name,	user_real_name,					user_password,	user_newpassword,	user_newpass_time,
user_email,	user_email_authenticated,		user_options,	user_token,			user_registration,	user_editcount)
VALUES (
'Anonymous','',								NULL,			NULL,				CURRENT_TIMESTAMP,
NULL, 		NULL,							NULL,			NULL,				CURRENT_timestamp,	0);


CREATE TABLE user_groups (
  ug_user   BIGINT NOT NULL DEFAULT 0,
  --    REFERENCES user(user_id) ON DELETE CASCADE,
  ug_group  VARCHAR(255)     NOT NULL
);
CREATE UNIQUE INDEX user_groups_unique ON user_groups (ug_user, ug_group);
--leonsp:
CREATE UNIQUE INDEX user_groups_include_idx
	ON user_groups(ug_user)
	INCLUDE (ug_group);


CREATE TABLE user_newtalk (
  -- registered users key
  user_id              BIGINT      NOT NULL DEFAULT 0,
  --  REFERENCES user(user_id) ON DELETE CASCADE,
  -- anonymous users key
  user_ip              VARCHAR(40),
  user_last_timestamp  TIMESTAMP(3)
);
CREATE INDEX user_newtalk_id_idx ON user_newtalk (user_id);
CREATE INDEX user_newtalk_ip_idx ON user_newtalk (user_ip);
--leonsp:
CREATE UNIQUE INDEX user_newtalk_include_idx
	ON user_newtalk(user_id, user_ip)
	INCLUDE (user_last_timestamp);


CREATE TABLE page (
  page_id			 BIGINT PRIMARY KEY GENERATED BY DEFAULT AS IDENTITY (START WITH 0),
  page_namespace     SMALLINT       NOT NULL,
  page_title         VARCHAR(255)   NOT NULL,
  page_restrictions  VARCHAR(1024),
  page_counter       BIGINT         NOT NULL  DEFAULT 0,
  page_is_redirect   SMALLINT       NOT NULL  DEFAULT 0,
  page_is_new        SMALLINT       NOT NULL  DEFAULT 0,
  page_random        NUMERIC(15,14) NOT NULL,
  page_touched       TIMESTAMP(3),
  page_latest        BIGINT	        NOT NULL, -- FK?
  page_len           BIGINT        NOT NULL
);
CREATE UNIQUE INDEX page_unique_name ON page (page_namespace, page_title);
CREATE INDEX page_random_idx         ON page (page_random);
CREATE INDEX page_len_idx            ON page (page_len);
--leonsp:
CREATE UNIQUE INDEX page_id_include
	ON page (page_id)
	INCLUDE (page_namespace, page_title, page_restrictions, page_counter, page_is_redirect, page_is_new, page_random, page_touched, page_latest, page_len);
CREATE UNIQUE INDEX page_name_include
	ON page (page_namespace, page_title)
	INCLUDE (page_id, page_restrictions, page_counter, page_is_redirect, page_is_new, page_random, page_touched, page_latest, page_len);


CREATE TABLE revision (
  rev_id			BIGINT PRIMARY KEY GENERATED BY DEFAULT AS IDENTITY (START WITH 0),
  rev_page        	BIGINT NOT NULL DEFAULT 0,
  --      REFERENCES page (page_id) ON DELETE CASCADE,
  rev_text_id     	BIGINT, -- FK
  rev_comment     	VARCHAR(1024),
  rev_user        	BIGINT      NOT NULL DEFAULT 0,
  --  REFERENCES user(user_id) ON DELETE RESTRICT,
  rev_user_text   	VARCHAR(255) NOT NULL,
  rev_timestamp   	TIMESTAMP(3)    NOT NULL,
  rev_minor_edit  	SMALLINT     NOT NULL  DEFAULT 0,
  rev_deleted     	SMALLINT     NOT NULL  DEFAULT 0,
  rev_len         	BIGINT,
  rev_parent_id   	BIGINT					DEFAULT NULL
);
CREATE UNIQUE INDEX revision_unique ON revision (rev_page, rev_id);
CREATE INDEX rev_text_id_idx        ON revision (rev_text_id);
CREATE INDEX rev_timestamp_idx      ON revision (rev_timestamp);
CREATE INDEX rev_user_idx           ON revision (rev_user);
CREATE INDEX rev_user_text_idx      ON revision (rev_user_text);



CREATE TABLE text ( -- replaces reserved word 'text'
  --old_id     INTEGER  NOT NULL,
  old_id	INTEGER PRIMARY KEY GENERATED BY DEFAULT AS IDENTITY (START WITH 0),
  --PRIMARY KEY DEFAULT nextval('text_old_id_val'),
  old_text   CLOB(16M) INLINE LENGTH 4096,
  old_flags  VARCHAR(1024)
);


CREATE TABLE page_restrictions (
  --pr_id      INTEGER      NOT NULL  UNIQUE, --DEFAULT nextval('pr_id_val'),
  --pr_id	INTEGER PRIMARY KEY GENERATED BY DEFAULT AS IDENTITY (START WITH 0),
  pr_id		BIGINT PRIMARY KEY GENERATED BY DEFAULT AS IDENTITY (START WITH 0),
  pr_page    INTEGER              NOT NULL DEFAULT 0,
  --(used to be nullable)
  --  REFERENCES page (page_id) ON DELETE CASCADE,
  pr_type    VARCHAR(60)         NOT NULL,
  pr_level   VARCHAR(60)         NOT NULL,
  pr_cascade SMALLINT             NOT NULL,
  pr_user    INTEGER,
  pr_expiry  TIMESTAMP(3)
  --PRIMARY KEY (pr_page, pr_type)
);
--ALTER TABLE page_restrictions ADD CONSTRAINT page_restrictions_pk PRIMARY KEY (pr_page,pr_type);
CREATE UNIQUE INDEX pr_pagetype ON page_restrictions (pr_page,pr_type);
CREATE INDEX pr_typelevel ON page_restrictions (pr_type,pr_level);
CREATE INDEX pr_level ON page_restrictions (pr_level);
CREATE INDEX pr_cascade ON page_restrictions (pr_cascade);

CREATE TABLE page_props (
  pp_page      INTEGER  NOT NULL DEFAULT 0,
  -- REFERENCES page (page_id) ON DELETE CASCADE,
  pp_propname  VARCHAR(255)     NOT NULL,
  pp_value     CLOB(64K) INLINE LENGTH 4096     NOT NULL,
  PRIMARY KEY (pp_page,pp_propname) 
);
--ALTER TABLE page_props ADD CONSTRAINT page_props_pk PRIMARY KEY (pp_page,pp_propname);
CREATE INDEX page_props_propname ON page_props (pp_propname);



CREATE TABLE archive (
  ar_namespace   SMALLINT     NOT NULL,
  ar_title       VARCHAR(255)         NOT NULL,
  ar_text        CLOB(16M) INLINE LENGTH 4096,
  ar_comment     VARCHAR(1024),
  ar_user        BIGINT NOT NULL,
  -- no foreign keys in MySQL
  -- REFERENCES user(user_id) ON DELETE SET NULL,
  ar_user_text   VARCHAR(255)         NOT NULL,
  ar_timestamp   TIMESTAMP(3)  NOT NULL,
  ar_minor_edit  SMALLINT     NOT NULL  DEFAULT 0,
  ar_flags       VARCHAR(1024),
  ar_rev_id      INTEGER,
  ar_text_id     INTEGER,
  ar_deleted     SMALLINT     NOT NULL  DEFAULT 0,
  ar_len         INTEGER,
  ar_page_id     INTEGER,
  ar_parent_id   INTEGER
);
CREATE INDEX archive_name_title_timestamp ON archive (ar_namespace,ar_title,ar_timestamp);
CREATE INDEX archive_user_text            ON archive (ar_user_text);



CREATE TABLE redirect (
  rd_from       BIGINT  NOT NULL  PRIMARY KEY,
  --REFERENCES page(page_id) ON DELETE CASCADE,
  rd_namespace  SMALLINT NOT NULL  DEFAULT 0,
  rd_title      VARCHAR(255)     NOT NULL DEFAULT '',
  rd_interwiki  varchar(32),
  rd_fragment   VARCHAR(255)
);
CREATE INDEX redirect_ns_title ON redirect (rd_namespace,rd_title,rd_from);


CREATE TABLE pagelinks (
  pl_from       BIGINT   NOT NULL DEFAULT 0,
  -- REFERENCES page(page_id) ON DELETE CASCADE,
  pl_namespace  SMALLINT  NOT NULL,
  pl_title      VARCHAR(255)      NOT NULL
);
CREATE UNIQUE INDEX pagelink_unique ON pagelinks (pl_from,pl_namespace,pl_title);

CREATE TABLE templatelinks (
  tl_from       BIGINT  NOT NULL DEFAULT 0,
  --  REFERENCES page(page_id) ON DELETE CASCADE,
  tl_namespace  SMALLINT NOT NULL,
  tl_title      VARCHAR(255)     NOT NULL
);
CREATE UNIQUE INDEX templatelinks_unique ON templatelinks (tl_namespace,tl_title,tl_from);
CREATE UNIQUE INDEX tl_from_idx ON templatelinks (tl_from,tl_namespace,tl_title);

CREATE TABLE imagelinks (
  il_from  BIGINT  NOT NULL  DEFAULT 0,
  -- REFERENCES page(page_id) ON DELETE CASCADE,
  il_to    VARCHAR(255)     NOT NULL
);
CREATE UNIQUE INDEX il_from_idx ON imagelinks (il_to,il_from);
CREATE UNIQUE INDEX il_to_idx ON imagelinks (il_from,il_to);

CREATE TABLE categorylinks (
  cl_from       BIGINT      NOT NULL  DEFAULT 0,
  -- REFERENCES page(page_id) ON DELETE CASCADE,
  cl_to         VARCHAR(255)         NOT NULL,
  -- cl_sortkey has to be at least 86 wide 
  -- in order to be compatible with the old MySQL schema from MW 1.10
  cl_sortkey    VARCHAR(86),
  cl_timestamp  TIMESTAMP(3)  NOT NULL
);
CREATE UNIQUE INDEX cl_from ON categorylinks (cl_from, cl_to);
CREATE INDEX cl_sortkey     ON categorylinks (cl_to, cl_sortkey, cl_from);



CREATE TABLE externallinks (
  el_from   BIGINT  NOT NULL DEFAULT 0,
  -- REFERENCES page(page_id) ON DELETE CASCADE,
  el_to     VARCHAR(1024)     NOT NULL,
  el_index  VARCHAR(1024)     NOT NULL
);
CREATE INDEX externallinks_from_to ON externallinks (el_from,el_to);
CREATE INDEX externallinks_index   ON externallinks (el_index);


--
-- Track external user accounts, if ExternalAuth is used
--
CREATE TABLE external_user (
  -- Foreign key to user_id
  eu_local_id			BIGINT NOT NULL PRIMARY KEY,

  -- Some opaque identifier provided by the external database
  eu_external_id		VARCHAR(255) NOT NULL
);
CREATE UNIQUE INDEX eu_external_id_idx
	ON external_user (eu_external_id)
	INCLUDE (eu_local_id);
CREATE UNIQUE INDEX eu_local_id_idx
	ON external_user (eu_local_id)
	INCLUDE (eu_external_id);



CREATE TABLE langlinks (
  ll_from    BIGINT  NOT NULL DEFAULT 0,
  -- REFERENCES page (page_id) ON DELETE CASCADE,
  ll_lang    VARCHAR(20),
  ll_title   VARCHAR(255)
);
CREATE UNIQUE INDEX langlinks_unique ON langlinks (ll_from,ll_lang);
CREATE INDEX langlinks_lang_title    ON langlinks (ll_lang,ll_title);


CREATE TABLE site_stats (
  ss_row_id         BIGINT	  NOT NULL  UNIQUE,
  ss_total_views    BIGINT            DEFAULT 0,
  ss_total_edits    BIGINT            DEFAULT 0,
  ss_good_articles  BIGINT             DEFAULT 0,
  ss_total_pages    INTEGER            DEFAULT -1,
  ss_users          INTEGER            DEFAULT -1,
  ss_active_users   INTEGER            DEFAULT -1,
  ss_admins         INTEGER            DEFAULT -1,
  ss_images         INTEGER            DEFAULT 0
);

CREATE TABLE hitcounter (
  hc_id  BIGINT  NOT NULL
);

CREATE TABLE ipblocks (
  ipb_id                INTEGER      NOT NULL  PRIMARY KEY,
  --DEFAULT nextval('ipblocks_ipb_id_val'),
  ipb_address           VARCHAR(1024),
  ipb_user              BIGINT NOT NULL DEFAULT 0,
  --           REFERENCES user(user_id) ON DELETE SET NULL,
  ipb_by                BIGINT      NOT NULL DEFAULT 0,
  --  REFERENCES user(user_id) ON DELETE CASCADE,
  ipb_by_text           VARCHAR(255)         NOT NULL  DEFAULT '',
  ipb_reason            VARCHAR(1024)         NOT NULL,
  ipb_timestamp         TIMESTAMP(3)  NOT NULL,
  ipb_auto              SMALLINT     NOT NULL  DEFAULT 0,
  ipb_anon_only         SMALLINT     NOT NULL  DEFAULT 0,
  ipb_create_account    SMALLINT     NOT NULL  DEFAULT 1,
  ipb_enable_autoblock  SMALLINT     NOT NULL  DEFAULT 1,
  ipb_expiry            TIMESTAMP(3)  NOT NULL,
  ipb_range_start       VARCHAR(1024),
  ipb_range_end         VARCHAR(1024),
  ipb_deleted           SMALLINT     NOT NULL  DEFAULT 0,
  ipb_block_email       SMALLINT     NOT NULL  DEFAULT 0,
  ipb_allow_usertalk    SMALLINT     NOT NULL  DEFAULT 0

);
CREATE INDEX ipb_address ON ipblocks (ipb_address);
CREATE INDEX ipb_user    ON ipblocks (ipb_user);
CREATE INDEX ipb_range   ON ipblocks (ipb_range_start,ipb_range_end);



CREATE TABLE image (
  img_name         VARCHAR(255)      NOT NULL  PRIMARY KEY,
  img_size         BIGINT   NOT NULL,
  img_width        INTEGER   NOT NULL,
  img_height       INTEGER   NOT NULL,
  img_metadata     CLOB(16M) INLINE LENGTH 4096     NOT NULL  DEFAULT '',
  img_bits         SMALLINT,
  img_media_type   VARCHAR(255),
  img_major_mime   VARCHAR(255)                DEFAULT 'unknown',
  img_minor_mime   VARCHAR(32)                DEFAULT 'unknown',
  img_description  VARCHAR(1024)      NOT NULL	DEFAULT '',
  img_user         BIGINT NOT NULL DEFAULT 0,
  --         REFERENCES user(user_id) ON DELETE SET NULL,
  img_user_text    VARCHAR(255)      NOT NULL DEFAULT '',
  img_timestamp    TIMESTAMP(3),
  img_sha1         VARCHAR(255)      NOT NULL  DEFAULT ''
);
CREATE INDEX img_size_idx      ON image (img_size);
CREATE INDEX img_timestamp_idx ON image (img_timestamp);
CREATE INDEX img_sha1          ON image (img_sha1);

CREATE TABLE oldimage (
  oi_name          VARCHAR(255)         NOT NULL DEFAULT '',
  oi_archive_name  VARCHAR(255)         NOT NULL,
  oi_size          BIGINT      NOT NULL,
  oi_width         INTEGER      NOT NULL,
  oi_height        INTEGER      NOT NULL,
  oi_bits          SMALLINT     NOT NULL,
  oi_description   VARCHAR(1024),
  oi_user          BIGINT NOT NULL DEFAULT 0,
  --            REFERENCES user(user_id) ON DELETE SET NULL,
  oi_user_text     VARCHAR(255)         NOT NULL,
  oi_timestamp     TIMESTAMP(3)  NOT NULL,
  oi_metadata      CLOB(16M) INLINE LENGTH 4096        NOT NULL DEFAULT '',
  oi_media_type    VARCHAR(255)             ,
  oi_major_mime    VARCHAR(255)         NOT NULL DEFAULT 'unknown',
  oi_minor_mime    VARCHAR(255)         NOT NULL DEFAULT 'unknown',
  oi_deleted       SMALLINT     NOT NULL DEFAULT 0,
  oi_sha1          VARCHAR(255)         NOT NULL DEFAULT ''
  --FOREIGN KEY (oi_name) REFERENCES image(img_name) ON DELETE CASCADE
);
--ALTER TABLE oldimage ADD CONSTRAINT oldimage_oi_name_fkey_cascade FOREIGN KEY (oi_name) REFERENCES image(img_name) ON DELETE CASCADE;
CREATE INDEX oi_name_timestamp    ON oldimage (oi_name,oi_timestamp);
CREATE INDEX oi_name_archive_name ON oldimage (oi_name,oi_archive_name);
CREATE INDEX oi_sha1              ON oldimage (oi_sha1);



CREATE TABLE filearchive (
  fa_id                 INTEGER      NOT NULL PRIMARY KEY,
  --PRIMARY KEY DEFAULT nextval('filearchive_fa_id_seq'),
  fa_name               VARCHAR(255)         NOT NULL,
  fa_archive_name       VARCHAR(255),
  fa_storage_group      VARCHAR(255),
  fa_storage_key        VARCHAR(64)			DEFAULT '',
  fa_deleted_user       BIGINT NOT NULL	DEFAULT 0,
  --            REFERENCES user(user_id) ON DELETE SET NULL,
  fa_deleted_timestamp  TIMESTAMP(3)  NOT NULL,
  fa_deleted_reason     VARCHAR(255),
  fa_size               BIGINT      NOT NULL,
  fa_width              INTEGER      NOT NULL,
  fa_height             INTEGER      NOT NULL,
  fa_metadata           CLOB(16M) INLINE LENGTH 4096        NOT NULL  DEFAULT '',
  fa_bits               SMALLINT,
  fa_media_type         VARCHAR(255),
  fa_major_mime         VARCHAR(255)                   DEFAULT 'unknown',
  fa_minor_mime         VARCHAR(255)                   DEFAULT 'unknown',
  fa_description        VARCHAR(1024)         NOT NULL,
  fa_user               BIGINT NOT NULL DEFAULT 0,
  --            REFERENCES user(user_id) ON DELETE SET NULL,
  fa_user_text          VARCHAR(255)         NOT NULL,
  fa_timestamp          TIMESTAMP(3),
  fa_deleted            SMALLINT     NOT NULL DEFAULT 0
);
CREATE INDEX fa_name_time ON filearchive (fa_name, fa_timestamp);
CREATE INDEX fa_dupe      ON filearchive (fa_storage_group, fa_storage_key);
CREATE INDEX fa_notime    ON filearchive (fa_deleted_timestamp);
CREATE INDEX fa_nouser    ON filearchive (fa_deleted_user);


CREATE TABLE recentchanges (
  rc_id              INTEGER      NOT NULL PRIMARY KEY,
  --PRIMARY KEY DEFAULT nextval('rc_rc_id_seq'),
  rc_timestamp       TIMESTAMP(3)  NOT NULL,
  rc_cur_time        TIMESTAMP(3)  NOT NULL,
  rc_user            BIGINT NOT NULL DEFAULT 0,
  --        REFERENCES user(user_id) ON DELETE SET NULL,
  rc_user_text       VARCHAR(255)         NOT NULL,
  rc_namespace       SMALLINT     NOT NULL,
  rc_title           VARCHAR(255)         NOT NULL,
  rc_comment         VARCHAR(255),
  rc_minor           SMALLINT     NOT NULL  DEFAULT 0,
  rc_bot             SMALLINT     NOT NULL  DEFAULT 0,
  rc_new             SMALLINT     NOT NULL  DEFAULT 0,
  rc_cur_id          BIGINT NOT NULL DEFAULT 0,
  --            REFERENCES page(page_id) ON DELETE SET NULL,
  rc_this_oldid      BIGINT      NOT NULL,
  rc_last_oldid      BIGINT      NOT NULL,
  rc_type            SMALLINT     NOT NULL  DEFAULT 0,
  rc_moved_to_ns     SMALLINT,
  rc_moved_to_title  VARCHAR(255),
  rc_patrolled       SMALLINT     NOT NULL  DEFAULT 0,
  rc_ip              VARCHAR(40),	-- was CIDR type
  rc_old_len         INTEGER,
  rc_new_len         INTEGER,
  rc_deleted         SMALLINT     NOT NULL  DEFAULT 0,
  rc_logid           BIGINT      NOT NULL  DEFAULT 0,
  rc_log_type        VARCHAR(255),
  rc_log_action      VARCHAR(255),
  rc_params          CLOB(64K) INLINE LENGTH 4096
  
);
CREATE INDEX rc_timestamp       ON recentchanges (rc_timestamp);
CREATE INDEX rc_namespace_title ON recentchanges (rc_namespace, rc_title);
CREATE INDEX rc_cur_id          ON recentchanges (rc_cur_id);
CREATE INDEX new_name_timestamp ON recentchanges (rc_new, rc_namespace, rc_timestamp);
CREATE INDEX rc_ip              ON recentchanges (rc_ip);



CREATE TABLE watchlist (
  wl_user                   BIGINT     NOT NULL DEFAULT 0,
  --  REFERENCES user(user_id) ON DELETE CASCADE,
  wl_namespace              SMALLINT    NOT NULL  DEFAULT 0,
  wl_title                  VARCHAR(255)        NOT NULL,
  wl_notificationtimestamp  TIMESTAMP(3)
);
CREATE UNIQUE INDEX wl_user_namespace_title ON watchlist (wl_namespace, wl_title, wl_user);


CREATE TABLE math (
  math_inputhash              VARCHAR(16) FOR BIT DATA     NOT NULL  UNIQUE,
  math_outputhash             VARCHAR(16) FOR BIT DATA     NOT NULL,
  math_html_conservativeness  SMALLINT  NOT NULL,
  math_html                   CLOB(64K) INLINE LENGTH 4096,
  math_mathml                 CLOB(64K) INLINE LENGTH 4096
);


CREATE TABLE interwiki (
  iw_prefix  VARCHAR(32)      NOT NULL  UNIQUE,
  iw_url     CLOB(64K) INLINE LENGTH 4096      NOT NULL,
  iw_local   SMALLINT  NOT NULL,
  iw_trans   SMALLINT  NOT NULL  DEFAULT 0
);


CREATE TABLE querycache (
  qc_type       VARCHAR(255)      NOT NULL,
  qc_value      BIGINT   NOT NULL,
  qc_namespace  INTEGER  NOT NULL,
  qc_title      VARCHAR(255)      NOT NULL
);
CREATE INDEX querycache_type_value ON querycache (qc_type, qc_value);



CREATE  TABLE querycache_info (
  qci_type        VARCHAR(255)              UNIQUE NOT NULL,
  qci_timestamp  TIMESTAMP(3)
);


CREATE TABLE querycachetwo (
  qcc_type           VARCHAR(255)     NOT NULL,
  qcc_value         BIGINT  NOT NULL  DEFAULT 0,
  qcc_namespace     INTEGER  NOT NULL  DEFAULT 0,
  qcc_title          VARCHAR(255)     NOT NULL  DEFAULT '',
  qcc_namespacetwo  INTEGER  NOT NULL  DEFAULT 0,
  qcc_titletwo       VARCHAR(255)     NOT NULL  DEFAULT ''
);
CREATE INDEX querycachetwo_type_value ON querycachetwo (qcc_type, qcc_value);
CREATE INDEX querycachetwo_title      ON querycachetwo (qcc_type,qcc_namespace,qcc_title);
CREATE INDEX querycachetwo_titletwo   ON querycachetwo (qcc_type,qcc_namespacetwo,qcc_titletwo);

CREATE TABLE objectcache (
  keyname   VARCHAR(255)           NOT NULL        UNIQUE, -- was nullable
  value     CLOB(16M) INLINE LENGTH 4096                   NOT NULL  DEFAULT '',
  exptime  TIMESTAMP(3)               NOT NULL
);
CREATE INDEX objectcacache_exptime ON objectcache (exptime);



CREATE TABLE transcache (
  tc_url       VARCHAR(255)         NOT NULL  UNIQUE,
  tc_contents  CLOB(64K) INLINE LENGTH 4096         NOT NULL,
  tc_time      TIMESTAMP(3)  NOT NULL
);


CREATE TABLE logging (
  log_id			BIGINT      NOT NULL PRIMARY KEY,
  --PRIMARY KEY DEFAULT nextval('log_log_id_seq'),
  log_type			VARCHAR(32)         NOT NULL,
  log_action		VARCHAR(32)         NOT NULL,
  log_timestamp		TIMESTAMP(3)  NOT NULL,
  log_user			BIGINT NOT NULL DEFAULT 0,
  --                REFERENCES user(user_id) ON DELETE SET NULL,
  -- Name of the user who performed this action
  log_user_text		VARCHAR(255) NOT NULL default '',
  log_namespace		SMALLINT     NOT NULL,
  log_title			VARCHAR(255)         NOT NULL,
  log_page			BIGINT,
  log_comment		VARCHAR(255),
  log_params		CLOB(64K) INLINE LENGTH 4096,
  log_deleted		SMALLINT     NOT NULL DEFAULT 0
);
CREATE INDEX logging_type_name ON logging (log_type, log_timestamp);
CREATE INDEX logging_user_time ON logging (log_timestamp, log_user);
CREATE INDEX logging_page_time ON logging (log_namespace, log_title, log_timestamp);
CREATE INDEX log_user_type_time ON logging (log_user, log_type, log_timestamp);
CREATE INDEX log_page_id_time ON logging (log_page,log_timestamp);



CREATE TABLE trackbacks (
  tb_id     INTEGER  NOT NULL PRIMARY KEY,
  --PRIMARY KEY DEFAULT nextval('trackbacks_tb_id_seq'),
  -- foreign key also in MySQL
  tb_page   INTEGER REFERENCES page(page_id) ON DELETE CASCADE,
  tb_title  VARCHAR(255)     NOT NULL,
  tb_url    CLOB(64K) INLINE LENGTH 4096	     NOT NULL,
  tb_ex     CLOB(64K) INLINE LENGTH 4096,
  tb_name   VARCHAR(255)
);
CREATE INDEX trackback_page ON trackbacks (tb_page);



CREATE TABLE job (
  job_id         BIGINT   NOT NULL PRIMARY KEY,
  --PRIMARY KEY DEFAULT nextval('job_job_id_seq'),
  job_cmd        VARCHAR(255)      NOT NULL,
  job_namespace  SMALLINT  NOT NULL,
  job_title      VARCHAR(255)      NOT NULL,
  job_params     CLOB(64K) INLINE LENGTH 4096      NOT NULL
);
CREATE INDEX job_cmd_namespace_title ON job (job_cmd, job_namespace, job_title);



-- Postgres' Tsearch2 dropped
--ALTER TABLE page ADD titlevector tsvector;
--CREATE FUNCTION ts2_page_title() RETURNS TRIGGER LANGUAGE plpgsql AS
--$mw$
--BEGIN
--IF TG_OP = 'INSERT' THEN
--  NEW.titlevector = to_tsvector('default',REPLACE(NEW.page_title,'/',' '));
--ELSIF NEW.page_title != OLD.page_title THEN
--  NEW.titlevector := to_tsvector('default',REPLACE(NEW.page_title,'/',' '));
--END IF;
--RETURN NEW;
--END;
--$mw$;

--CREATE TRIGGER ts2_page_title BEFORE INSERT OR UPDATE ON page
--  FOR EACH ROW EXECUTE PROCEDURE ts2_page_title();


--ALTER TABLE text ADD textvector tsvector;
--CREATE FUNCTION ts2_page_text() RETURNS TRIGGER LANGUAGE plpgsql AS
--$mw$
--BEGIN
--IF TG_OP = 'INSERT' THEN
--  NEW.textvector = to_tsvector('default',NEW.old_text);
--ELSIF NEW.old_text != OLD.old_text THEN
--  NEW.textvector := to_tsvector('default',NEW.old_text);
--END IF;
--RETURN NEW;
--END;
--$mw$;

--CREATE TRIGGER ts2_page_text BEFORE INSERT OR UPDATE ON text
--  FOR EACH ROW EXECUTE PROCEDURE ts2_page_text();

-- These are added by the setup script due to version compatibility issues
-- If using 8.1, we switch from "gin" to "gist"

--CREATE INDEX ts2_page_title ON page USING gin(titlevector);
--CREATE INDEX ts2_page_text ON text USING gin(textvector);

--TODO
--CREATE FUNCTION add_interwiki (TEXT,INT,SMALLINT) RETURNS INT LANGUAGE SQL AS
--$mw$
--  INSERT INTO interwiki (iw_prefix, iw_url, iw_local) VALUES ($1,$2,$3);
--  SELECT 1;
--$mw$;

-- hack implementation
-- should be replaced with OmniFind, Contains(), etc
CREATE TABLE searchindex (
  si_page BIGINT NOT NULL,
  si_title varchar(255) NOT NULL default '',
  si_text clob NOT NULL
);

-- This table is not used unless profiling is turned on
CREATE TABLE profiling (
  pf_count   INTEGER         NOT NULL DEFAULT 0,
  pf_time    NUMERIC(18,10)  NOT NULL DEFAULT 0,
  pf_memory  NUMERIC(18,10)  NOT NULL DEFAULT 0,
  pf_name    VARCHAR(255)            NOT NULL,
  pf_server  VARCHAR(255)            
);
CREATE UNIQUE INDEX pf_name_server ON profiling (pf_name, pf_server);

CREATE TABLE protected_titles (
  pt_namespace   INTEGER    NOT NULL,
  pt_title       VARCHAR(255)        NOT NULL,
  pt_user        BIGINT NOT NULL DEFAULT 0,
  --       REFERENCES user(user_id) ON DELETE SET NULL,
  pt_reason      VARCHAR(1024),
  pt_timestamp   TIMESTAMP(3) NOT NULL,
  pt_expiry      TIMESTAMP(3)     ,
  pt_create_perm VARCHAR(60)        NOT NULL DEFAULT ''
);
CREATE UNIQUE INDEX protected_titles_unique ON protected_titles(pt_namespace, pt_title);



CREATE TABLE updatelog (
  ul_key VARCHAR(255) NOT NULL PRIMARY KEY
);


CREATE TABLE category (
  cat_id       INTEGER  NOT NULL PRIMARY KEY,
  --PRIMARY KEY DEFAULT nextval('category_id_seq'),
  cat_title    VARCHAR(255)     NOT NULL,
  cat_pages    INTEGER  NOT NULL  DEFAULT 0,
  cat_subcats  INTEGER  NOT NULL  DEFAULT 0,
  cat_files    INTEGER  NOT NULL  DEFAULT 0,
  cat_hidden   SMALLINT NOT NULL  DEFAULT 0
);
CREATE UNIQUE INDEX category_title ON category(cat_title);
CREATE INDEX category_pages ON category(cat_pages);

-- added for 1.15

-- A table to track tags for revisions, logs and recent changes.
CREATE TABLE change_tag (
  ct_rc_id INTEGER,
  ct_log_id INTEGER,
  ct_rev_id INTEGER,
  ct_tag varchar(255) NOT NULL,
  ct_params CLOB(64K) INLINE LENGTH 4096
);
CREATE UNIQUE INDEX change_tag_rc_tag ON change_tag (ct_rc_id,ct_tag);
CREATE UNIQUE INDEX change_tag_log_tag ON change_tag (ct_log_id,ct_tag);
CREATE UNIQUE INDEX change_tag_rev_tag ON change_tag (ct_rev_id,ct_tag);
-- Covering index, so we can pull all the info only out of the index.
CREATE INDEX change_tag_tag_id ON change_tag (ct_tag,ct_rc_id,ct_rev_id,ct_log_id);


-- Rollup table to pull a LIST of tags simply
CREATE TABLE tag_summary (
  ts_rc_id INTEGER,
  ts_log_id INTEGER,
  ts_rev_id INTEGER,
  ts_tags CLOB(64K) INLINE LENGTH 4096 NOT NULL
);
CREATE UNIQUE INDEX tag_summary_rc_id ON tag_summary (ts_rc_id);
CREATE UNIQUE INDEX tag_summary_log_id ON tag_summary (ts_log_id);
CREATE UNIQUE INDEX tag_summary_rev_id ON tag_summary (ts_rev_id);


CREATE TABLE valid_tag (
  vt_tag varchar(255) NOT NULL PRIMARY KEY
);

--
-- User preferences and perhaps other fun stuff. :)
-- Replaces the old user.user_options blob, with a couple nice properties:
--
-- 1) We only store non-default settings, so changes to the defaults
--    are now reflected for everybody, not just new accounts.
-- 2) We can more easily do bulk lookups, statistics, or modifications of
--    saved options since it's a sane table structure.
--
CREATE TABLE user_properties (
  -- Foreign key to user.user_id
  up_user BIGINT NOT NULL,
  
  -- Name of the option being saved. This is indexed for bulk lookup.
  up_property VARCHAR(32) FOR BIT DATA NOT NULL,
  
  -- Property value as a string.
  up_value CLOB(64K) INLINE LENGTH 4096
);
CREATE UNIQUE INDEX user_properties_user_property ON user_properties (up_user,up_property);
CREATE INDEX user_properties_property ON user_properties (up_property);

CREATE TABLE log_search (
  -- The type of ID (rev ID, log ID, rev TIMESTAMP(3), username)
  ls_field VARCHAR(32) FOR BIT DATA NOT NULL,
  -- The value of the ID
  ls_value varchar(255) NOT NULL,
  -- Key to log_id
  ls_log_id BIGINT NOT NULL default 0
);
CREATE UNIQUE INDEX ls_field_val ON log_search (ls_field,ls_value,ls_log_id);
CREATE INDEX ls_log_id ON log_search (ls_log_id);

CREATE TABLE mediawiki_version (
  type         VARCHAR(1024)         NOT NULL,
  mw_version   VARCHAR(1024)         NOT NULL,
  notes        VARCHAR(1024)         ,

  pg_version   VARCHAR(1024)         ,
  pg_dbname    VARCHAR(1024)         ,
  pg_user      VARCHAR(1024)         ,
  pg_port      VARCHAR(1024)         ,
  mw_schema    VARCHAR(1024)         ,
  ts2_schema   VARCHAR(1024)         ,
  ctype        VARCHAR(1024)         ,

  sql_version  VARCHAR(1024)         ,
  sql_date     VARCHAR(1024)         ,
  cdate        TIMESTAMP(3)  NOT NULL DEFAULT CURRENT TIMESTAMP
);

INSERT INTO mediawiki_version (type,mw_version,sql_version,sql_date)
  VALUES ('Creation','??','$LastChangedRevision: 34049 $','$LastChangedDate: 2008-04-30 10:20:36 -0400 (Wed, 30 Apr 2008) $');

-- Table for storing localisation data
CREATE TABLE l10n_cache (
  -- Language code
  lc_lang			VARCHAR(32) NOT NULL,
  -- Cache key
  lc_key			VARCHAR(255) NOT NULL,
  -- Value
  lc_value			CLOB(16M) INLINE LENGTH 4096 NOT NULL
);
CREATE INDEX lc_lang_key ON l10n_cache (lc_lang, lc_key);

