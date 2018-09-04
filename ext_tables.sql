#
# Table structure for table 'tx_pxapmimporter_domain_model_import'
#
CREATE TABLE tx_pxapmimporter_domain_model_import (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	configuration_path varchar(255) DEFAULT '' NOT NULL,
	last_execution int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# Table structure for table 'tx_pxaproductmanager_domain_model_product'
#
CREATE TABLE tx_pxaproductmanager_domain_model_product (
	pm_importer_import_id_hash varchar(55) DEFAULT '' NOT NULL,
	pm_importer_import_id varchar(55) DEFAULT '' NOT NULL
);

#
# Table structure for table 'sys_category'
#
CREATE TABLE sys_category (
	pm_importer_import_id_hash varchar(55) DEFAULT '' NOT NULL,
	pm_importer_import_id varchar(255) DEFAULT '' NOT NULL
);

#
# Table structure for table 'tx_pxaproductmanager_domain_model_attribute'
#
CREATE TABLE tx_pxaproductmanager_domain_model_attribute (
	pm_importer_import_id_hash varchar(55) DEFAULT '' NOT NULL,
	pm_importer_import_id varchar(255) DEFAULT '' NOT NULL
);