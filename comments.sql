--
-- Table `tbl_user_comments`
--

CREATE TABLE `tbl_user_comments` (
  `id` int(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `message` varchar(500) NOT NULL,
  `create_at_timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Table `tbl_user_comments`
--
ALTER TABLE `tbl_user_comments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_user_comments`
--
ALTER TABLE `tbl_user_comments`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;
COMMIT;