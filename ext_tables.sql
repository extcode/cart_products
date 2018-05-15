#
# Table structure for table 'tx_cartproducts_domain_model_product_product'
#
CREATE TABLE tx_cartproducts_domain_model_product_product (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    product_type varchar(255) DEFAULT 'simple' NOT NULL,

    sku varchar(255) DEFAULT '' NOT NULL,
    title varchar(255) DEFAULT '' NOT NULL,
    teaser text NOT NULL,
    description text NOT NULL,

    min_number_in_order int(11) unsigned DEFAULT '0' NOT NULL,
    max_number_in_order int(11) unsigned DEFAULT '0' NOT NULL,

    price double(11,2) DEFAULT '0.00' NOT NULL,
    is_net_price tinyint(4) unsigned DEFAULT '0' NOT NULL,
    special_prices int(11) unsigned DEFAULT '0' NOT NULL,
    quantity_discounts int(11) unsigned DEFAULT '0' NOT NULL,
    price_measure double(11,2) DEFAULT '0.00' NOT NULL,
    price_measure_unit varchar(8) DEFAULT '' NOT NULL,
    base_price_measure double(11,2) DEFAULT '0.00' NOT NULL,
    base_price_measure_unit varchar(8) DEFAULT '' NOT NULL,

    service_attribute1 double(11,2) DEFAULT '0.00' NOT NULL,
    service_attribute2 double(11,2) DEFAULT '0.00' NOT NULL,
    service_attribute3 double(11,2) DEFAULT '0.00' NOT NULL,

    handle_stock tinyint(4) unsigned DEFAULT '0' NOT NULL,
    handle_stock_in_variants tinyint(4) unsigned DEFAULT '0' NOT NULL,
    stock int(11) unsigned DEFAULT '0' NOT NULL,

    tax_class_id int(11) unsigned DEFAULT '1' NOT NULL,

    product_content int(11) DEFAULT '0' NOT NULL,

    images varchar(255) DEFAULT '' NOT NULL,
    files varchar(255) DEFAULT '' NOT NULL,

    be_variant_attribute1 int(11) unsigned DEFAULT '0' NOT NULL,
    be_variant_attribute2 int(11) unsigned DEFAULT '0' NOT NULL,
    be_variant_attribute3 int(11) unsigned DEFAULT '0' NOT NULL,

    fe_variants int(11) unsigned DEFAULT '0' NOT NULL,
    be_variants int(11) unsigned DEFAULT '0' NOT NULL,

    related_products int(11) DEFAULT '0' NOT NULL,
    related_products_from int(11) DEFAULT '0' NOT NULL,

    category int(11) unsigned DEFAULT '0' NOT NULL,
    categories int(11) unsigned DEFAULT '0' NOT NULL,
    tags int(11) DEFAULT '0' NOT NULL,

    sorting int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    starttime int(11) unsigned DEFAULT '0' NOT NULL,
    endtime int(11) unsigned DEFAULT '0' NOT NULL,

    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(255) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage int(11) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3ver_move_id int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),
    KEY language (l10n_parent,sys_language_uid)
);

#
# Table structure for table 'tx_cartproducts_domain_model_product_specialprice'
#
CREATE TABLE tx_cartproducts_domain_model_product_specialprice (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    product int(11) unsigned DEFAULT '0' NOT NULL,
    be_variant int(11) unsigned DEFAULT '0' NOT NULL,

    title varchar(255) DEFAULT '' NOT NULL,

    frontend_user_group int(11) unsigned DEFAULT '0' NOT NULL,

    price double(11,2) DEFAULT '0.00' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    starttime int(11) unsigned DEFAULT '0' NOT NULL,
    endtime int(11) unsigned DEFAULT '0' NOT NULL,

    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(255) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage int(11) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3ver_move_id int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),
    KEY language (l10n_parent,sys_language_uid)
);

#
# Table structure for table 'tx_cartproducts_domain_model_product_quantitydiscount'
#
CREATE TABLE tx_cartproducts_domain_model_product_quantitydiscount (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    product int(11) unsigned DEFAULT '0' NOT NULL,

    frontend_user_group int(11) unsigned DEFAULT '0' NOT NULL,

    price double(11,2) DEFAULT '0.00' NOT NULL,
    quantity int(11) unsigned DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(255) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage int(11) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3ver_move_id int(11) DEFAULT '0' NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),
);

#
# Table structure for table 'tx_cartproducts_domain_model_product_bevariantattribute'
#
CREATE TABLE tx_cartproducts_domain_model_product_bevariantattribute (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    product int(11) unsigned DEFAULT '0' NOT NULL,
    be_variant_attribute_options int(11) unsigned DEFAULT '0' NOT NULL,

    sku varchar(255) DEFAULT '' NOT NULL,
    title varchar(255) DEFAULT '' NOT NULL,
    description text NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    starttime int(11) unsigned DEFAULT '0' NOT NULL,
    endtime int(11) unsigned DEFAULT '0' NOT NULL,

    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(255) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage int(11) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3ver_move_id int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),
    KEY language (l10n_parent,sys_language_uid)
);

#
# Table structure for table 'tx_cartproducts_domain_model_product_bevariantattributeoption'
#
CREATE TABLE tx_cartproducts_domain_model_product_bevariantattributeoption (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    be_variant_attribute int(11) unsigned DEFAULT '0' NOT NULL,

    sku varchar(255) DEFAULT '' NOT NULL,
    title varchar(255) DEFAULT '' NOT NULL,
    description text NOT NULL,

    sorting int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    starttime int(11) unsigned DEFAULT '0' NOT NULL,
    endtime int(11) unsigned DEFAULT '0' NOT NULL,

    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(255) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage int(11) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3ver_move_id int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),
    KEY language (l10n_parent,sys_language_uid)
);

#
# Table structure for table 'tx_cartproducts_domain_model_product_fevariant'
#
CREATE TABLE tx_cartproducts_domain_model_product_fevariant (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    product int(11) unsigned DEFAULT '0' NOT NULL,

    is_required tinyint(4) unsigned DEFAULT '0' NOT NULL,

    sku varchar(255) DEFAULT '' NOT NULL,
    title varchar(255) DEFAULT '' NOT NULL,

    sorting int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    starttime int(11) unsigned DEFAULT '0' NOT NULL,
    endtime int(11) unsigned DEFAULT '0' NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);

#
# Table structure for table 'tx_cartproducts_domain_model_product_bevariant'
#
CREATE TABLE tx_cartproducts_domain_model_product_bevariant (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    product int(11) unsigned DEFAULT '0' NOT NULL,

    be_variant_attribute_option1 int(11) unsigned DEFAULT '0' NOT NULL,
    be_variant_attribute_option2 int(11) unsigned DEFAULT '0' NOT NULL,
    be_variant_attribute_option3 int(11) unsigned DEFAULT '0' NOT NULL,

    price double(11,2) DEFAULT '0.00' NOT NULL,

    special_prices int(11) unsigned DEFAULT '0' NOT NULL,

    price_calc_method int(11) unsigned DEFAULT '0' NOT NULL,
    price_measure double(11,2) DEFAULT '0.00' NOT NULL,
    price_measure_unit varchar(8) DEFAULT '' NOT NULL,

    stock int(11) unsigned DEFAULT '0' NOT NULL,

    sorting int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    starttime int(11) unsigned DEFAULT '0' NOT NULL,
    endtime int(11) unsigned DEFAULT '0' NOT NULL,

    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(255) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage int(11) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3ver_move_id int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),
    KEY language (l10n_parent,sys_language_uid)
);

#
# Table structure for table 'tx_cartproducts_domain_model_product_tag'
#
CREATE TABLE tx_cartproducts_domain_model_product_tag (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    title varchar(255) DEFAULT '' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    starttime int(11) unsigned DEFAULT '0' NOT NULL,
    endtime int(11) unsigned DEFAULT '0' NOT NULL,

    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(255) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage int(11) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3ver_move_id int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),
    KEY language (l10n_parent,sys_language_uid)
);

#
# Extend table structure of table 'tt_content'
#
CREATE TABLE tt_content (
    tx_cartproducts_domain_model_product_product int(11) unsigned DEFAULT '0' NOT NULL
);

#
# Table structure for table 'tx_cartproducts_domain_model_product_product_related_mm'
#
CREATE TABLE tx_cartproducts_domain_model_product_product_related_mm (
    uid_local int(11) DEFAULT '0' NOT NULL,
    uid_foreign int(11) DEFAULT '0' NOT NULL,
    sorting int(11) DEFAULT '0' NOT NULL,
    sorting_foreign int(11) DEFAULT '0' NOT NULL,
    KEY uid_local (uid_local),
    KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_cartproducts_domain_model_product_tag_mm'
#
CREATE TABLE tx_cartproducts_domain_model_product_tag_mm (
    uid_local int(11) DEFAULT '0' NOT NULL,
    uid_foreign int(11) DEFAULT '0' NOT NULL,
    sorting int(11) DEFAULT '0' NOT NULL,
    sorting_foreign int(11) DEFAULT '0' NOT NULL,
    KEY uid_local (uid_local),
    KEY uid_foreign (uid_foreign)
);

#
# Extend table structure of table 'sys_category'
#
CREATE TABLE sys_category (
    images int(11) unsigned DEFAULT '0',
    cart_product_list_pid int(11) unsigned DEFAULT '0' NOT NULL,
    cart_product_show_pid int(11) unsigned DEFAULT '0' NOT NULL
);
