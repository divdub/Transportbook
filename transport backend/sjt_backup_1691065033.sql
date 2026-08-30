

CREATE TABLE `inc_exp_head` (
  `inc_exp_id` int(11) NOT NULL AUTO_INCREMENT,
  `head_name` varchar(300) NOT NULL,
  `head_type` varchar(300) NOT NULL,
  `remark` varchar(300) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`inc_exp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO inc_exp_head VALUES("1","RTO","Expenses","test","2023-08-01","2023-08-01");



CREATE TABLE `m_agent` (
  `agent_id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_name` varchar(300) NOT NULL,
  `other_name` varchar(300) NOT NULL,
  `email_id` varchar(300) NOT NULL,
  `mobileno1` bigint(11) NOT NULL,
  `mobileno2` bigint(20) NOT NULL,
  `ag_address` varchar(5000) NOT NULL,
  `gst_no` varchar(300) NOT NULL,
  `pan_no` varchar(300) NOT NULL,
  `opn_balnc` varchar(300) NOT NULL,
  `opn_balnc_date` date NOT NULL,
  `upload_aadhar` varchar(300) NOT NULL,
  `acc_holder_name` varchar(300) NOT NULL,
  `acc_no` varchar(300) NOT NULL,
  `ifsc_code` varchar(300) NOT NULL,
  `bank_name` varchar(300) NOT NULL,
  `branch_name` varchar(300) NOT NULL,
  `acc_type` varchar(300) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`agent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO m_agent VALUES("1","radhe","radheshyam","rakesh@gmail.com","1263254445","2147483647","raipur","4444444444444","444444444","4","2023-02-05","DOC1690873794176.8.png","radhe","8899778897222","sbino1245654356","sbi ","raipur","Saving","2023-08-01","2023-08-01");



CREATE TABLE `m_company` (
  `comp_id` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(300) NOT NULL,
  `ownername` varchar(300) NOT NULL,
  `emailid` varchar(300) NOT NULL,
  `mobileno1` int(11) NOT NULL,
  `mobileno2` int(11) NOT NULL,
  `clogo` varchar(300) NOT NULL,
  `gst_no` varchar(200) NOT NULL,
  `bank_name` varchar(300) NOT NULL,
  `pan_no` varchar(300) NOT NULL,
  `ifsc_code` varchar(300) NOT NULL,
  `caddress` varchar(5000) NOT NULL,
  `acc_holder_name` varchar(300) NOT NULL,
  `acc_no` varchar(300) NOT NULL,
  `branch_name` varchar(300) NOT NULL,
  `acc_type` varchar(300) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`comp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO m_company VALUES("7","PRITHVI LOGISTICS","SHREE JEET","transport@gmail.com","1111111111","2147483647","DOC1690886035134.9.jpg","111","sbi","111","sbino1245654356","Khushalpur chowk ,raipur Pin- code:492001","shree","8899778897222","raipur","Saving","2023-07-29","2023-08-02");



CREATE TABLE `m_consignee` (
  `consignee_id` int(11) NOT NULL AUTO_INCREMENT,
  `consignee_name` varchar(300) NOT NULL,
  `mobile_no` bigint(20) NOT NULL,
  `email_id` varchar(300) NOT NULL,
  `consignee_address` varchar(5000) NOT NULL,
  `place_id` int(11) NOT NULL,
  `gst_no` varchar(300) NOT NULL,
  `pan_no` varchar(300) NOT NULL,
  `opn_balnc` varchar(300) NOT NULL,
  `opn_balnc_date` date NOT NULL,
  `acc_holder_name` varchar(300) NOT NULL,
  `acc_no` varchar(300) NOT NULL,
  `ifsc_code` varchar(300) NOT NULL,
  `bank_name` varchar(300) NOT NULL,
  `branch_name` varchar(300) NOT NULL,
  `acc_type` varchar(300) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`consignee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO m_consignee VALUES("1","shree","2222222222","rakesh@gmail.com","raipur","1","24CG564","spx45656","0","2023-07-20","sita","8899778897222","sbino1245654356","sbi ","raipur","Saving","2023-08-01","2023-08-01");



CREATE TABLE `m_consignor` (
  `consignor_id` int(11) NOT NULL AUTO_INCREMENT,
  `consignor_name` varchar(300) NOT NULL,
  `mobile_no` bigint(11) NOT NULL,
  `email_id` varchar(300) NOT NULL,
  `consignor_address` varchar(300) NOT NULL,
  `place_id` int(11) NOT NULL,
  `gst_no` varchar(300) NOT NULL,
  `pan_no` varchar(300) NOT NULL,
  `opn_balnc` varchar(300) NOT NULL,
  `opn_balnc_date` date NOT NULL,
  `acc_holder_name` varchar(300) NOT NULL,
  `acc_no` varchar(200) NOT NULL,
  `ifsc_code` varchar(300) NOT NULL,
  `bank_name` varchar(300) NOT NULL,
  `branch_name` varchar(300) NOT NULL,
  `acc_type` varchar(300) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`consignor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO m_consignor VALUES("1","Shree Jeet Cement","8888888888","solanki@gmail.com","raipur","1","24CG525","spx45656","15","2023-07-25","shree","8899778897222","sbino1245635656","rrrrr","raipur","Saving","2023-08-01","2023-08-01");



CREATE TABLE `m_driver` (
  `driver_id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_name` varchar(300) NOT NULL,
  `mobile_no` bigint(200) NOT NULL,
  `daddress` varchar(5000) NOT NULL,
  `aadhar_no` varchar(300) NOT NULL,
  `licence_no` varchar(300) NOT NULL,
  `lic_exp_date` date NOT NULL,
  `upload_aadhar` varchar(300) NOT NULL,
  `upload_licence` varchar(300) NOT NULL,
  `salary` bigint(200) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`driver_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO m_driver VALUES("1","narayan","8585858585","raipur","898978874444","DEG5657852522222","2024-09-09","DOC1690960206409.6.jpg","DOC1690960206412.2.png","0","2023-08-02","2023-08-02");



CREATE TABLE `m_employee` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_name` varchar(300) NOT NULL,
  `mobile_no` bigint(200) NOT NULL,
  `eaddress` varchar(300) NOT NULL,
  `aadhar_no` varchar(300) NOT NULL,
  `licence_no` varchar(300) NOT NULL,
  `date_of_join` date NOT NULL,
  `upload_aadhar` varchar(300) NOT NULL,
  `upload_licence` varchar(300) NOT NULL,
  `salary` bigint(200) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO m_employee VALUES("1","Ram Singh","8888888888","raipur","222222222222","1222222224545552","2023-07-02","DOC1690958319173.8.jpg","DOC1690958405398.7.jpg","10000","2023-08-02","2023-08-02");



CREATE TABLE `m_item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(300) NOT NULL,
  `item_category_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO m_item VALUES("1","Shree","1","1","2023-07-31","2023-07-31");



CREATE TABLE `m_item_category` (
  `item_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(300) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`item_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO m_item_category VALUES("1","Cement","2023-07-31","2023-07-31");



CREATE TABLE `m_petrol_pump` (
  `pump_id` int(11) NOT NULL AUTO_INCREMENT,
  `pump_name` varchar(300) NOT NULL,
  `head_name` varchar(300) NOT NULL,
  `mobile_no` bigint(20) NOT NULL,
  `paddress` varchar(5000) NOT NULL,
  `opn_balnc` varchar(300) NOT NULL,
  `opn_balnc_date` date NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`pump_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO m_petrol_pump VALUES("1","ram petrol pump","SHRIRAM","5896647777","raipur","10","2023-07-25","2023-08-01","2023-08-01");



CREATE TABLE `m_place` (
  `place_id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) NOT NULL,
  `place_name` varchar(300) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`place_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO m_place VALUES("1","8","Bilashpur","2023-07-31","2023-07-31");



CREATE TABLE `m_session` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `session_start` date NOT NULL,
  `session_end` date NOT NULL,
  `session_name` varchar(300) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO m_session VALUES("1","2023-04-01","2024-03-31","2023-2024","2023-07-29","2023-07-29");



CREATE TABLE `m_state` (
  `state_id` int(11) NOT NULL,
  `state_name` varchar(300) NOT NULL,
  `state_code` int(11) NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO m_state VALUES("1","Andaman and Nicobar Islands","35");
INSERT INTO m_state VALUES("2","Andhra Pradesh","28");
INSERT INTO m_state VALUES("3","Andhra Pradesh (New)","37");
INSERT INTO m_state VALUES("4","Arunachal Pradesh","12");
INSERT INTO m_state VALUES("5","Assam","18");
INSERT INTO m_state VALUES("6","Bihar","10");
INSERT INTO m_state VALUES("7","Chandigarh","4");
INSERT INTO m_state VALUES("8","Chattisgarh","22");
INSERT INTO m_state VALUES("9","Dadra and Nagar Haveli","26");
INSERT INTO m_state VALUES("10","Daman and Diu","25");
INSERT INTO m_state VALUES("11","Delhi","7");
INSERT INTO m_state VALUES("12","Goa","30");
INSERT INTO m_state VALUES("13","Gujarat","24");
INSERT INTO m_state VALUES("14","Haryana","6");
INSERT INTO m_state VALUES("15","Himachal Pradesh","2");
INSERT INTO m_state VALUES("16","Jammu and Kashmir","1");
INSERT INTO m_state VALUES("17","Jharkhand","20");
INSERT INTO m_state VALUES("18","Karnataka","29");
INSERT INTO m_state VALUES("19","Kerala","32");
INSERT INTO m_state VALUES("20","Lakshadweep Islands","31");
INSERT INTO m_state VALUES("21","Madhya Pradesh","23");
INSERT INTO m_state VALUES("22","Maharashtra","27");
INSERT INTO m_state VALUES("23","Manipur","14");
INSERT INTO m_state VALUES("24","Meghalaya","17");
INSERT INTO m_state VALUES("25","Mizoram","15");
INSERT INTO m_state VALUES("26","Nagaland","13");
INSERT INTO m_state VALUES("27","Odisha","21");
INSERT INTO m_state VALUES("28","Pondicherry","34");
INSERT INTO m_state VALUES("29","Punjab","3");
INSERT INTO m_state VALUES("30","Rajasthan","8");
INSERT INTO m_state VALUES("31","Sikkim","11");
INSERT INTO m_state VALUES("32","Tamil Nadu","33");
INSERT INTO m_state VALUES("33","Telangana","36");
INSERT INTO m_state VALUES("34","Tripura","16");
INSERT INTO m_state VALUES("35","Uttar Pradesh","9");
INSERT INTO m_state VALUES("36","Uttarakhand","5");
INSERT INTO m_state VALUES("37","West Bengal","19");



CREATE TABLE `m_supplier` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `supp_name` varchar(300) NOT NULL,
  `hname` varchar(300) NOT NULL,
  `mobile_no` bigint(20) NOT NULL,
  `email_id` varchar(300) NOT NULL,
  `gst_no` varchar(300) NOT NULL,
  `pan_no` varchar(300) NOT NULL,
  `saddress` varchar(5000) NOT NULL,
  `place_id` int(11) NOT NULL,
  `acc_holder_name` varchar(300) NOT NULL,
  `acc_no` varchar(300) NOT NULL,
  `ifsc_code` varchar(300) NOT NULL,
  `bank_name` varchar(300) NOT NULL,
  `branch_name` varchar(300) NOT NULL,
  `acc_type` varchar(300) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO m_supplier VALUES("1","Shikhar Singh","Shiv","7878878787","solanki@gmail.com","24CG525","spx45656","Raipur","1","radhe","8899778897222","sbino1245635656","sbi ","raipur","Current","2023-08-02","2023-08-02");



CREATE TABLE `m_unit` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(300) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO m_unit VALUES("1","MT","2023-07-31","2023-07-31");



CREATE TABLE `m_userlogin` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(300) NOT NULL,
  `user_type` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO m_userlogin VALUES("1","admin","admin","123","2023-07-29","0000-00-00");



CREATE TABLE `m_vehicle` (
  `vehicle_id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_no` varchar(300) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `vehicle_type_id` int(11) NOT NULL,
  `chassis_no` varchar(300) NOT NULL,
  `engine_no` varchar(300) NOT NULL,
  `uploaded_rc` varchar(300) NOT NULL,
  `meter_read` varchar(300) NOT NULL,
  `meter_read_date` date NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`vehicle_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO m_vehicle VALUES("1","CG04MV34563","2","1","1","5555555","4444445","DOC1690877886104.jpg","12","2023-02-05","2023-08-01","2023-08-01");



CREATE TABLE `m_vehicle_owner` (
  `owner_id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_name` varchar(300) NOT NULL,
  `other_name` varchar(300) NOT NULL,
  `email_id` varchar(300) NOT NULL,
  `mobileno1` bigint(11) NOT NULL,
  `mobileno2` bigint(11) NOT NULL,
  `owner_type` varchar(200) NOT NULL,
  `oaddress` varchar(5000) NOT NULL,
  `place_id` int(11) NOT NULL,
  `tds` int(11) NOT NULL,
  `gst_no` varchar(300) NOT NULL,
  `pan_no` varchar(300) NOT NULL,
  `upload_declaration` varchar(300) NOT NULL,
  `opn_balnc` varchar(300) NOT NULL,
  `opn_balnc_date` date NOT NULL,
  `acc_holder_name` varchar(300) NOT NULL,
  `acc_no` varchar(300) NOT NULL,
  `ifsc_code` varchar(300) NOT NULL,
  `bank_name` varchar(300) NOT NULL,
  `branch_name` varchar(300) NOT NULL,
  `acc_type` varchar(300) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`owner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO m_vehicle_owner VALUES("2","sonali Sharma","sneh","solanki@gmail.com","2147483647","2147483647","Self","raipur","1","1","24CG525","spx45656","DOC1690869473824.6.png","10","2023-08-01","sita","7888777777777777","sbino1245635656","rrrrr","wee","Saving","2023-08-01","2023-08-01");



CREATE TABLE `m_vehicle_type` (
  `vehicle_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_type` varchar(300) NOT NULL,
  `no_of_wheels` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  PRIMARY KEY (`vehicle_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO m_vehicle_type VALUES("1","truck","15","2023-07-31","2023-07-31");

