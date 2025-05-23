USE [master]
GO
/****** Object:  Database [Healthcare_Database]    Script Date: 18/5/2025 5:54:26 PM ******/
CREATE DATABASE [Healthcare_Database]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'Heathcare_Database', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL16.MSSQLSERVER\MSSQL\DATA\Heathcare_Database.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'Heathcare_Database_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL16.MSSQLSERVER\MSSQL\DATA\Heathcare_Database_log.ldf' , SIZE = 204800KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
 WITH CATALOG_COLLATION = DATABASE_DEFAULT, LEDGER = OFF
GO
ALTER DATABASE [Healthcare_Database] SET COMPATIBILITY_LEVEL = 160
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [Healthcare_Database].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [Healthcare_Database] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [Healthcare_Database] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [Healthcare_Database] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [Healthcare_Database] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [Healthcare_Database] SET ARITHABORT OFF 
GO
ALTER DATABASE [Healthcare_Database] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [Healthcare_Database] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [Healthcare_Database] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [Healthcare_Database] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [Healthcare_Database] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [Healthcare_Database] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [Healthcare_Database] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [Healthcare_Database] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [Healthcare_Database] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [Healthcare_Database] SET  DISABLE_BROKER 
GO
ALTER DATABASE [Healthcare_Database] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [Healthcare_Database] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [Healthcare_Database] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [Healthcare_Database] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [Healthcare_Database] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [Healthcare_Database] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [Healthcare_Database] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [Healthcare_Database] SET RECOVERY FULL 
GO
ALTER DATABASE [Healthcare_Database] SET  MULTI_USER 
GO
ALTER DATABASE [Healthcare_Database] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [Healthcare_Database] SET DB_CHAINING OFF 
GO
ALTER DATABASE [Healthcare_Database] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [Healthcare_Database] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [Healthcare_Database] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [Healthcare_Database] SET ACCELERATED_DATABASE_RECOVERY = OFF  
GO
EXEC sys.sp_db_vardecimal_storage_format N'Healthcare_Database', N'ON'
GO
ALTER DATABASE [Healthcare_Database] SET ENCRYPTION ON
GO
ALTER DATABASE [Healthcare_Database] SET QUERY_STORE = ON
GO
ALTER DATABASE [Healthcare_Database] SET QUERY_STORE (OPERATION_MODE = READ_WRITE, CLEANUP_POLICY = (STALE_QUERY_THRESHOLD_DAYS = 30), DATA_FLUSH_INTERVAL_SECONDS = 900, INTERVAL_LENGTH_MINUTES = 60, MAX_STORAGE_SIZE_MB = 1000, QUERY_CAPTURE_MODE = AUTO, SIZE_BASED_CLEANUP_MODE = AUTO, MAX_PLANS_PER_QUERY = 200, WAIT_STATS_CAPTURE_MODE = ON)
GO
/* For security reasons the login is created disabled and with a random password. */
/****** Object:  Login [roleChecker]    Script Date: 18/5/2025 5:54:26 PM ******/
CREATE LOGIN [roleChecker] WITH PASSWORD=N'IflIn4ziLzUdtj/SwPy6B3gvJLHkYNC4Z9A/X3fIzSw=', DEFAULT_DATABASE=[Healthcare_Database], DEFAULT_LANGUAGE=[us_english], CHECK_EXPIRATION=ON, CHECK_POLICY=ON
GO
ALTER LOGIN [roleChecker] DISABLE
GO
/* For security reasons the login is created disabled and with a random password. */
/****** Object:  Login [PatientUser]    Script Date: 18/5/2025 5:54:26 PM ******/
CREATE LOGIN [PatientUser] WITH PASSWORD=N'U1Pjsr+9IPyIrOIN+yytBrAD87wwSUbUbob8/S1B+2A=', DEFAULT_DATABASE=[master], DEFAULT_LANGUAGE=[us_english], CHECK_EXPIRATION=ON, CHECK_POLICY=ON
GO
ALTER LOGIN [PatientUser] DISABLE
GO
/****** Object:  Login [NT SERVICE\Winmgmt]    Script Date: 18/5/2025 5:54:26 PM ******/
CREATE LOGIN [NT SERVICE\Winmgmt] FROM WINDOWS WITH DEFAULT_DATABASE=[master], DEFAULT_LANGUAGE=[us_english]
GO
/****** Object:  Login [NT SERVICE\SQLWriter]    Script Date: 18/5/2025 5:54:26 PM ******/
CREATE LOGIN [NT SERVICE\SQLWriter] FROM WINDOWS WITH DEFAULT_DATABASE=[master], DEFAULT_LANGUAGE=[us_english]
GO
/****** Object:  Login [NT SERVICE\SQLTELEMETRY]    Script Date: 18/5/2025 5:54:26 PM ******/
CREATE LOGIN [NT SERVICE\SQLTELEMETRY] FROM WINDOWS WITH DEFAULT_DATABASE=[master], DEFAULT_LANGUAGE=[us_english]
GO
/****** Object:  Login [NT SERVICE\SQLSERVERAGENT]    Script Date: 18/5/2025 5:54:26 PM ******/
CREATE LOGIN [NT SERVICE\SQLSERVERAGENT] FROM WINDOWS WITH DEFAULT_DATABASE=[master], DEFAULT_LANGUAGE=[us_english]
GO
/****** Object:  Login [NT Service\MSSQLSERVER]    Script Date: 18/5/2025 5:54:26 PM ******/
CREATE LOGIN [NT Service\MSSQLSERVER] FROM WINDOWS WITH DEFAULT_DATABASE=[master], DEFAULT_LANGUAGE=[us_english]
GO
/****** Object:  Login [NT AUTHORITY\SYSTEM]    Script Date: 18/5/2025 5:54:26 PM ******/
CREATE LOGIN [NT AUTHORITY\SYSTEM] FROM WINDOWS WITH DEFAULT_DATABASE=[master], DEFAULT_LANGUAGE=[us_english]
GO
/* For security reasons the login is created disabled and with a random password. */
/****** Object:  Login [DoctorUser]    Script Date: 18/5/2025 5:54:26 PM ******/
CREATE LOGIN [DoctorUser] WITH PASSWORD=N'VzPr1J6ykC+Iww9InIz36NXMPmKrhJi3gamY8KjoWSc=', DEFAULT_DATABASE=[Healthcare_Database], DEFAULT_LANGUAGE=[us_english], CHECK_EXPIRATION=ON, CHECK_POLICY=ON
GO
ALTER LOGIN [DoctorUser] DISABLE
GO
/****** Object:  Login [DESKTOP-AP7NBC9\ahteo]    Script Date: 18/5/2025 5:54:26 PM ******/
CREATE LOGIN [DESKTOP-AP7NBC9\ahteo] FROM WINDOWS WITH DEFAULT_DATABASE=[master], DEFAULT_LANGUAGE=[us_english]
GO
/* For security reasons the login is created disabled and with a random password. */
/****** Object:  Login [AdminUser]    Script Date: 18/5/2025 5:54:26 PM ******/
CREATE LOGIN [AdminUser] WITH PASSWORD=N'bP+qv750v92Gv22M4bsLVp9nM7QBdwhayJZ70KVIZos=', DEFAULT_DATABASE=[Healthcare_Database], DEFAULT_LANGUAGE=[us_english], CHECK_EXPIRATION=ON, CHECK_POLICY=ON
GO
ALTER LOGIN [AdminUser] DISABLE
GO
/* For security reasons the login is created disabled and with a random password. */
/****** Object:  Login [##MS_PolicyTsqlExecutionLogin##]    Script Date: 18/5/2025 5:54:26 PM ******/
CREATE LOGIN [##MS_PolicyTsqlExecutionLogin##] WITH PASSWORD=N'7W3sfBtfrU30wJNyaF/lSC/GtSWleTOLUs9d8rHphMA=', DEFAULT_DATABASE=[master], DEFAULT_LANGUAGE=[us_english], CHECK_EXPIRATION=OFF, CHECK_POLICY=ON
GO
ALTER LOGIN [##MS_PolicyTsqlExecutionLogin##] DISABLE
GO
/* For security reasons the login is created disabled and with a random password. */
/****** Object:  Login [##MS_PolicyEventProcessingLogin##]    Script Date: 18/5/2025 5:54:26 PM ******/
CREATE LOGIN [##MS_PolicyEventProcessingLogin##] WITH PASSWORD=N'VniINvio/BjvIkaL9XYi1gluGyXiqiGdKad/I9W9mO8=', DEFAULT_DATABASE=[master], DEFAULT_LANGUAGE=[us_english], CHECK_EXPIRATION=OFF, CHECK_POLICY=ON
GO
ALTER LOGIN [##MS_PolicyEventProcessingLogin##] DISABLE
GO
ALTER SERVER ROLE [sysadmin] ADD MEMBER [NT SERVICE\Winmgmt]
GO
ALTER SERVER ROLE [sysadmin] ADD MEMBER [NT SERVICE\SQLWriter]
GO
ALTER SERVER ROLE [sysadmin] ADD MEMBER [NT SERVICE\SQLSERVERAGENT]
GO
ALTER SERVER ROLE [sysadmin] ADD MEMBER [NT Service\MSSQLSERVER]
GO
ALTER SERVER ROLE [sysadmin] ADD MEMBER [DESKTOP-AP7NBC9\ahteo]
GO
USE [Healthcare_Database]
GO
/****** Object:  User [roleChecker]    Script Date: 18/5/2025 5:54:26 PM ******/
CREATE USER [roleChecker] FOR LOGIN [roleChecker] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [PatientUser]    Script Date: 18/5/2025 5:54:26 PM ******/
CREATE USER [PatientUser] FOR LOGIN [PatientUser] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [DoctorUser]    Script Date: 18/5/2025 5:54:26 PM ******/
CREATE USER [DoctorUser] FOR LOGIN [DoctorUser] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [AdminUser]    Script Date: 18/5/2025 5:54:26 PM ******/
CREATE USER [AdminUser] FOR LOGIN [AdminUser] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  Table [dbo].[Admin]    Script Date: 18/5/2025 5:54:26 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Admin](
	[Admin_ID] [int] IDENTITY(1,1) NOT NULL,
	[User_ID] [int] NOT NULL,
	[Last_Access] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[Admin_ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Doctor]    Script Date: 18/5/2025 5:54:26 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Doctor](
	[Doctor_ID] [int] IDENTITY(1,1) NOT NULL,
	[User_ID] [int] NOT NULL,
	[Identification_number] [varchar](50) MASKED WITH (FUNCTION = 'partial(0, "XXXX-XXXX-", 4)') NULL,
	[Contact_number] [varchar](20) MASKED WITH (FUNCTION = 'partial(0, "XXX-XXX-", 4)') NULL,
	[Gender] [varchar](10) NULL,
	[Address] [varchar](255) NULL,
	[Specialization] [varchar](100) NULL,
	[Created_By_Admin_ID] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[Doctor_ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Medical_Record]    Script Date: 18/5/2025 5:54:26 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Medical_Record](
	[Medical_Record_ID] [int] IDENTITY(1,1) NOT NULL,
	[Patient_ID] [int] NOT NULL,
	[Doctor_ID] [int] NOT NULL,
	[Visit_Date] [datetime] NULL,
	[Diagnosis] [nvarchar](255) NULL,
	[Prescription] [nvarchar](255) NULL,
	[Notes] [nvarchar](255) NULL,
PRIMARY KEY CLUSTERED 
(
	[Medical_Record_ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Patient]    Script Date: 18/5/2025 5:54:26 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Patient](
	[Patient_ID] [int] IDENTITY(1,1) NOT NULL,
	[User_ID] [int] NOT NULL,
	[Identification_number] [varchar](50) MASKED WITH (FUNCTION = 'partial(0, "XXXX-XXXX-", 4)') NULL,
	[Contact_number] [varchar](20) MASKED WITH (FUNCTION = 'partial(0, "XXX-XXX-", 4)') NULL,
	[Gender] [varchar](10) NULL,
	[Address] [varchar](255) NULL,
	[First_visit] [datetime] NULL,
	[Created_By_Admin_ID] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[Patient_ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[User]    Script Date: 18/5/2025 5:54:26 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[User](
	[User_ID] [int] IDENTITY(1,1) NOT NULL,
	[Age] [int] NULL,
	[Name] [varchar](100) NULL,
	[Username] [varchar](100) NULL,
	[Password_Hashed] [varchar](255) NULL,
	[Role] [varchar](20) NULL,
	[Password] [varchar](255) NULL,
PRIMARY KEY CLUSTERED 
(
	[User_ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
SET IDENTITY_INSERT [dbo].[Admin] ON 

INSERT [dbo].[Admin] ([Admin_ID], [User_ID], [Last_Access]) VALUES (1, 5, NULL)
INSERT [dbo].[Admin] ([Admin_ID], [User_ID], [Last_Access]) VALUES (2, 7, NULL)
SET IDENTITY_INSERT [dbo].[Admin] OFF
GO
SET IDENTITY_INSERT [dbo].[Doctor] ON 

INSERT [dbo].[Doctor] ([Doctor_ID], [User_ID], [Identification_number], [Contact_number], [Gender], [Address], [Specialization], [Created_By_Admin_ID]) VALUES (1, 4, N'012131-49-1421', N'012-34567890', N'Female', N'no42, jalan chan', N'Cardiovascular', NULL)
INSERT [dbo].[Doctor] ([Doctor_ID], [User_ID], [Identification_number], [Contact_number], [Gender], [Address], [Specialization], [Created_By_Admin_ID]) VALUES (2, 6, N'012131-49-1421', N'011-2312312', N'Male', N'no21,jalan kim', N'Brain', NULL)
INSERT [dbo].[Doctor] ([Doctor_ID], [User_ID], [Identification_number], [Contact_number], [Gender], [Address], [Specialization], [Created_By_Admin_ID]) VALUES (3, 11, N'012131-49-1421', N'011-2141524', N'Male', N'no123,jalan 91, batu baha', N'Heart', 2)
INSERT [dbo].[Doctor] ([Doctor_ID], [User_ID], [Identification_number], [Contact_number], [Gender], [Address], [Specialization], [Created_By_Admin_ID]) VALUES (4, 14, N'014124-14-9412', N'012-14202412', N'Male', N'no90, jalan baiwa, 43920 selangor', N'skin ', 2)
SET IDENTITY_INSERT [dbo].[Doctor] OFF
GO
SET IDENTITY_INSERT [dbo].[Medical_Record] ON 

INSERT [dbo].[Medical_Record] ([Medical_Record_ID], [Patient_ID], [Doctor_ID], [Visit_Date], [Diagnosis], [Prescription], [Notes]) VALUES (1, 3, 3, CAST(N'2025-05-17T00:00:00.000' AS DateTime), N'Heart Disease Update', N'Open this medical, it will help the patient Update', N'One day, twice, after meal Update')
INSERT [dbo].[Medical_Record] ([Medical_Record_ID], [Patient_ID], [Doctor_ID], [Visit_Date], [Diagnosis], [Prescription], [Notes]) VALUES (2, 2, 3, CAST(N'2025-05-19T00:00:00.000' AS DateTime), N'Lung Infested, the virus go in update', N'it need oxygen, to help patient update', N'1 week 1 times, must come update')
INSERT [dbo].[Medical_Record] ([Medical_Record_ID], [Patient_ID], [Doctor_ID], [Visit_Date], [Diagnosis], [Prescription], [Notes]) VALUES (3, 2, 3, CAST(N'2025-05-20T00:00:00.000' AS DateTime), N'test', N'test', N'test')
SET IDENTITY_INSERT [dbo].[Medical_Record] OFF
GO
SET IDENTITY_INSERT [dbo].[Patient] ON 

INSERT [dbo].[Patient] ([Patient_ID], [User_ID], [Identification_number], [Contact_number], [Gender], [Address], [First_visit], [Created_By_Admin_ID]) VALUES (2, 3, N'021313-12-2141', N'011-22334455', N'Male', N'no123, jalan cyberjaya', CAST(N'2025-05-09T08:18:59.000' AS DateTime), NULL)
INSERT [dbo].[Patient] ([Patient_ID], [User_ID], [Identification_number], [Contact_number], [Gender], [Address], [First_visit], [Created_By_Admin_ID]) VALUES (3, 10, N'010412-12-1414', N'011-41225124', N'Male', N'no123, jalan 321, cheras', CAST(N'2025-05-15T11:29:28.000' AS DateTime), 2)
INSERT [dbo].[Patient] ([Patient_ID], [User_ID], [Identification_number], [Contact_number], [Gender], [Address], [First_visit], [Created_By_Admin_ID]) VALUES (4, 12, N'031412-14-9424', N'011-10424952', N'Female', N'no52, jalan besar, taman equine', CAST(N'2025-05-17T16:47:26.000' AS DateTime), 2)
INSERT [dbo].[Patient] ([Patient_ID], [User_ID], [Identification_number], [Contact_number], [Gender], [Address], [First_visit], [Created_By_Admin_ID]) VALUES (5, 13, N'019411-11-1901', N'011-13194211', N'NTS', N'no91, jalan limau ', CAST(N'2025-05-17T16:51:47.000' AS DateTime), 2)
SET IDENTITY_INSERT [dbo].[Patient] OFF
GO
SET IDENTITY_INSERT [dbo].[User] ON 

INSERT [dbo].[User] ([User_ID], [Age], [Name], [Username], [Password_Hashed], [Role], [Password]) VALUES (1, 22, N'dylan', N'dylanUser', N'$2y$10$9YzxJIXwLBCR25OyweHCeeSurhNDlTovs.qEJTMfU.SSGGq4.ww/S', N'Patient', NULL)
INSERT [dbo].[User] ([User_ID], [Age], [Name], [Username], [Password_Hashed], [Role], [Password]) VALUES (3, 22, N'dylan', N'dylanHehe', N'$2y$10$AjWo4Mv5TBgdqAntpXvcNOzx.06F5DHoeHc4p3NPu3Q4gf6CyKNSW', N'Patient', NULL)
INSERT [dbo].[User] ([User_ID], [Age], [Name], [Username], [Password_Hashed], [Role], [Password]) VALUES (4, 45, N'Doctor Chan', N'chanchan', N'$2y$10$re2H9P2y1GEEsBXiDJjLjeuMXH8QRFYQqWTGZPOj2ZhY048b2FYKG', N'Doctor', NULL)
INSERT [dbo].[User] ([User_ID], [Age], [Name], [Username], [Password_Hashed], [Role], [Password]) VALUES (5, 55, N'micheal', N'micheal05', N'$2y$10$bqif0RkwAAoRYUMHKw.pxebd5FgTp8uDkQJzZN3HKErYFwvvxSjry', N'Admin', NULL)
INSERT [dbo].[User] ([User_ID], [Age], [Name], [Username], [Password_Hashed], [Role], [Password]) VALUES (6, 42, N'mohammad', N'doctor kim', N'$2y$10$S7T4BOw6/CWVEfAsxiO41.iXW2Og9b7s1RBkrcgO0QTIkRbFyRqcC', N'Doctor', NULL)
INSERT [dbo].[User] ([User_ID], [Age], [Name], [Username], [Password_Hashed], [Role], [Password]) VALUES (7, 21, N'jack', N'jacker00', N'$2y$10$VU7ZicxX1T64v3wZLVz5DetBDQnTLzV6bpBhYg4j.0Kp0kiopkLte', N'Admin', NULL)
INSERT [dbo].[User] ([User_ID], [Age], [Name], [Username], [Password_Hashed], [Role], [Password]) VALUES (10, 23, N'ming', N'minguser', N'$2y$10$k4orMYJQEfaWmYBR.k2LpOAAxMqCi7F2mNPJ3Q2NGc4WTuKX5dn3y', N'Patient', NULL)
INSERT [dbo].[User] ([User_ID], [Age], [Name], [Username], [Password_Hashed], [Role], [Password]) VALUES (11, 23, N'Dr Ko', N'Doctor Ko', N'$2y$10$UBUXxQ96/61bxuwS5td8zuM4YlF5JVSt9jncaIRkHB5bcBp3ATnei', N'Doctor', NULL)
INSERT [dbo].[User] ([User_ID], [Age], [Name], [Username], [Password_Hashed], [Role], [Password]) VALUES (12, 24, N'ly', N'lyuser', N'$2y$10$nHECkynAuwabelM6p8geY.5ywXVqpIlFoLuV0fC2GyBvSg4z228qS', N'Patient', NULL)
INSERT [dbo].[User] ([User_ID], [Age], [Name], [Username], [Password_Hashed], [Role], [Password]) VALUES (13, 12, N'test', N'testuser', N'$2y$10$6IcFGNS/Y/WLaPKRlNkI9eApLpiwrRWrae81eQxv71n0dlIzRKuau', N'Patient', NULL)
INSERT [dbo].[User] ([User_ID], [Age], [Name], [Username], [Password_Hashed], [Role], [Password]) VALUES (14, 53, N'doctortest', N'doctortestuser', N'$2y$10$U.I1h1jZljD4FkSvH1X3GeVNBc7irBOIpUpxEmFG0xX.6bhTwo.ka', N'Doctor', NULL)
SET IDENTITY_INSERT [dbo].[User] OFF
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [UQ__User__536C85E4A7D93DAC]    Script Date: 18/5/2025 5:54:26 PM ******/
ALTER TABLE [dbo].[User] ADD UNIQUE NONCLUSTERED 
(
	[Username] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
ALTER TABLE [dbo].[Patient] ADD  DEFAULT (getdate()) FOR [First_visit]
GO
ALTER TABLE [dbo].[Admin]  WITH CHECK ADD FOREIGN KEY([User_ID])
REFERENCES [dbo].[User] ([User_ID])
GO
ALTER TABLE [dbo].[Doctor]  WITH CHECK ADD FOREIGN KEY([User_ID])
REFERENCES [dbo].[User] ([User_ID])
GO
ALTER TABLE [dbo].[Doctor]  WITH CHECK ADD  CONSTRAINT [FK_Doctor_Created_By_Admin] FOREIGN KEY([Created_By_Admin_ID])
REFERENCES [dbo].[Admin] ([Admin_ID])
GO
ALTER TABLE [dbo].[Doctor] CHECK CONSTRAINT [FK_Doctor_Created_By_Admin]
GO
ALTER TABLE [dbo].[Medical_Record]  WITH CHECK ADD FOREIGN KEY([Doctor_ID])
REFERENCES [dbo].[Doctor] ([Doctor_ID])
GO
ALTER TABLE [dbo].[Medical_Record]  WITH CHECK ADD FOREIGN KEY([Patient_ID])
REFERENCES [dbo].[Patient] ([Patient_ID])
GO
ALTER TABLE [dbo].[Patient]  WITH CHECK ADD FOREIGN KEY([User_ID])
REFERENCES [dbo].[User] ([User_ID])
GO
ALTER TABLE [dbo].[Patient]  WITH CHECK ADD  CONSTRAINT [FK_Patient_Created_By_Admin] FOREIGN KEY([Created_By_Admin_ID])
REFERENCES [dbo].[Admin] ([Admin_ID])
GO
ALTER TABLE [dbo].[Patient] CHECK CONSTRAINT [FK_Patient_Created_By_Admin]
GO
ALTER TABLE [dbo].[User]  WITH CHECK ADD CHECK  (([Role]='Doctor' OR [Role]='Patient' OR [Role]='Admin'))
GO
USE [master]
GO
ALTER DATABASE [Healthcare_Database] SET  READ_WRITE 
GO
