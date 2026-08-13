<%--<%@ Page Language="C#" AutoEventWireup="true"
    CodeBehind="AdminDashboard.aspx.cs"
    Inherits="Hospital_Management_System_01.AdminDashboard" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head runat="server">

    <title>Medilab - Admin Dashboard</title>

    <meta charset="utf-8" />

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0" />

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css"
        rel="stylesheet" />

    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css"
        rel="stylesheet" />

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fa;
        }

        /* HEADER */

        .admin-header {
            height: 70px;
            background: #1977cc;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .admin-logo {
            font-size: 27px;
            font-weight: 700;
        }

        .admin-logo span {
            font-size: 14px;
            font-weight: normal;
            margin-left: 8px;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-user i {
            font-size: 25px;
        }

        /* SIDEBAR */

        .sidebar {
            position: fixed;
            top: 70px;
            left: 0;
            bottom: 0;
            width: 250px;
            background: white;
            box-shadow: 2px 0 12px rgba(0,0,0,0.08);
            padding-top: 20px;
            overflow-y: auto;
            z-index: 999;
        }

        .sidebar-title {
            padding: 10px 25px 15px;
            color: #999;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 14px 25px;
            color: #444;
            text-decoration: none;
            font-size: 15px;
            transition: 0.3s;
        }

        .sidebar a i {
            font-size: 19px;
            color: #1977cc;
            min-width: 20px;
        }

        .sidebar a:hover {
            background: #eaf4fc;
            color: #1977cc;
        }

        .sidebar a.active {
            background: #1977cc;
            color: white;
        }

        .sidebar a.active i {
            color: white;
        }

        /* LOGOUT */

        .sidebar-logout {
            border-top: 1px solid #eeeeee;
            margin-top: 15px;
            padding-top: 10px;
            padding-bottom: 20px;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 15px;
            width: 100%;
            padding: 14px 25px;
            color: #dc3545 !important;
            text-decoration: none;
            font-size: 15px;
            background: transparent;
            border: none;
            cursor: pointer;
            text-align: left;
        }

        .logout-btn i {
            font-size: 19px;
            color: #dc3545;
        }

        .logout-btn:hover {
            background: #fff1f1;
        }

        /* MAIN */

        .main-content {
            margin-left: 250px;
            padding: 100px 30px 40px;
            min-height: 100vh;
        }

        .page-title {
            margin-bottom: 25px;
        }

        .page-title h2 {
            color: #2c4964;
            font-weight: 700;
        }

        .page-title p {
            color: #777;
        }

        /* WELCOME */

        .welcome-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        }

        .welcome-box h3 {
            color: #2c4964;
            font-weight: 700;
        }

        .welcome-box p {
            color: #777;
            margin: 0;
        }

        /* CARDS */

        .dashboard-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
            height: 100%;
        }

        .dashboard-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #eaf4fc;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .dashboard-card .icon i {
            font-size: 28px;
            color: #1977cc;
        }

        .dashboard-card h3 {
            font-size: 28px;
            color: #2c4964;
            font-weight: 700;
        }

        .dashboard-card p {
            color: #777;
        }

        /* RECENT */

        .recent-box {
            background: white;
            padding: 25px;
            margin-top: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        }

        .recent-box h4 {
            color: #2c4964;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .table th {
            background: #1977cc;
            color: white;
        }

    </style>

</head>

<body>

<form id="form1" runat="server">

    <!-- HEADER -->

    <header class="admin-header">

        <div class="admin-logo">
            Medilab
            <span>Hospital Management</span>
        </div>

        <div class="admin-user">

            <i class="bi bi-person-circle"></i>

            <asp:Label
                ID="lblAdminName"
                runat="server"
                Text="Admin">
            </asp:Label>

        </div>

    </header>


    <!-- SIDEBAR -->

    <aside class="sidebar">

        <div class="sidebar-title">
            Admin Panel
        </div>


        <!-- DASHBOARD -->

        <a href="AdminDashboard.aspx"
           class="active">

            <i class="bi bi-speedometer2"></i>

            <span>Dashboard</span>

        </a>


        <!-- PATIENTS IMPORTANT -->

        <a href="Patients.aspx">

            <i class="bi bi-people"></i>

            <span>Patients</span>

        </a>


        <!-- APPOINTMENTS -->

        <a href="Appointments.aspx">

            <i class="bi bi-calendar-check"></i>

            <span>Appointments</span>

        </a>


        <!-- DOCTORS -->

        <a href="Doctors.aspx">

            <i class="bi bi-person-badge"></i>

            <span>Doctors</span>

        </a>


        <!-- DEPARTMENTS -->

        <a href="Departments.aspx">

            <i class="bi bi-hospital"></i>

            <span>Departments</span>

        </a>


        <!-- SERVICES -->

        <a href="Services.aspx">

            <i class="bi bi-heart-pulse"></i>

            <span>Services</span>

        </a>


        <!-- ENQUIRIES -->

        <a href="Enquiries.aspx">

            <i class="bi bi-envelope"></i>

            <span>Enquiries</span>

        </a>


        <!-- REPORTS -->

        <a href="Reports.aspx">

            <i class="bi bi-bar-chart"></i>

            <span>Reports</span>

        </a>


        <!-- LOGOUT -->

        <div class="sidebar-logout">

            <asp:LinkButton
                ID="btnLogout"
                runat="server"
                CssClass="logout-btn"
                OnClick="btnLogout_Click">

                <i class="bi bi-box-arrow-right"></i>

                <span>Logout</span>

            </asp:LinkButton>

        </div>

    </aside>


    <!-- MAIN -->

    <main class="main-content">

        <div class="page-title">

            <h2>Admin Dashboard</h2>

            <p>Hospital Management System</p>

        </div>


        <!-- WELCOME -->

        <div class="welcome-box">

            <h3>

                Welcome,

                <asp:Label
                    ID="lblWelcome"
                    runat="server"
                    Text="Admin">
                </asp:Label>

            </h3>

            <p>
                Manage your Medilab Hospital Management System
                from the admin panel.
            </p>

        </div>


        <!-- CARDS -->

        <div class="row g-4">

            <div class="col-lg-3 col-md-6">

                <div class="dashboard-card">

                    <div class="icon">
                        <i class="bi bi-people"></i>
                    </div>

                    <h3>
                        <asp:Label
                            ID="lblPatients"
                            runat="server"
                            Text="0">
                        </asp:Label>
                    </h3>

                    <p>Total Patients</p>

                </div>

            </div>


            <div class="col-lg-3 col-md-6">

                <div class="dashboard-card">

                    <div class="icon">
                        <i class="bi bi-calendar-check"></i>
                    </div>

                    <h3>0</h3>

                    <p>Appointments</p>

                </div>

            </div>


            <div class="col-lg-3 col-md-6">

                <div class="dashboard-card">

                    <div class="icon">
                        <i class="bi bi-person-badge"></i>
                    </div>

                    <h3>0</h3>

                    <p>Doctors</p>

                </div>

            </div>


            <div class="col-lg-3 col-md-6">

                <div class="dashboard-card">

                    <div class="icon">
                        <i class="bi bi-hospital"></i>
                    </div>

                    <h3>0</h3>

                    <p>Departments</p>

                </div>

            </div>

        </div>


        <!-- RECENT PATIENTS -->

        <div class="recent-box">

            <h4>Recent Patients</h4>

            <div class="table-responsive">

                <asp:GridView
                    ID="gvPatients"
                    runat="server"
                    CssClass="table table-bordered table-hover"
                    AutoGenerateColumns="true">
                </asp:GridView>

            </div>

        </div>

    </main>

</form>

</body>

</html>--%>

<%@ Page Title="Admin Dashboard" Language="C#" MasterPageFile="~/AdminMaster.Master"
    AutoEventWireup="true"
    CodeBehind="AdminDashboard.aspx.cs"
    Inherits="Hospital_Management_System_01.AdminDashboard" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">

    <style>

        /* =========================================
           DASHBOARD PAGE
        ========================================= */

        .dashboard-page {
            background: #f4f7fb;
            min-height: calc(100vh - 65px);
        }


        /* =========================================
           PAGE HEADING
        ========================================= */

        .page-heading {
            margin-bottom: 30px;
        }

        .page-heading h2 {
            margin: 0;
            color: #2c4964;
            font-size: 32px;
            font-weight: 700;
        }

        .page-heading p {
            margin: 6px 0 0;
            color: #7b8794;
            font-size: 15px;
        }


        /* =========================================
           STATISTICS CARDS
        ========================================= */

        .stat-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.07);
            height: 100%;
            transition: 0.25s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 22px rgba(0,0,0,0.10);
        }


        .stat-icon {
            width: 52px;
            height: 52px;

            border-radius: 12px;

            background: #e8f4fc;
            color: #1977cc;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 24px;

            margin-bottom: 15px;
        }


        .stat-card h6 {
            margin: 0 0 7px;

            color: #7b8794;

            font-size: 14px;
            font-weight: 500;
        }


        .stat-card h3 {
            margin: 0;

            color: #2c4964;

            font-size: 28px;
            font-weight: 700;
        }


        /* =========================================
           DASHBOARD CARD
        ========================================= */

        .dashboard-card {
            background: #ffffff;

            border-radius: 14px;

            padding: 25px;

            box-shadow: 0 4px 18px rgba(0,0,0,0.07);

            height: 100%;
        }


        /* =========================================
           CARD HEADER
        ========================================= */

        .dashboard-card-header {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 20px;
        }


        .dashboard-card-header h4 {
            margin: 0;

            color: #2c4964;

            font-size: 20px;

            font-weight: 600;
        }


        .dashboard-card-header h4 i {
            color: #1977cc;

            margin-right: 7px;
        }


        .view-all {
            color: #1977cc;

            text-decoration: none;

            font-size: 13px;

            font-weight: 600;
        }


        .view-all:hover {
            color: #125fa5;
        }


        /* =========================================
           PATIENT TABLE
        ========================================= */

        .dashboard-table {
            width: 100%;

            margin-bottom: 0;
        }


        .dashboard-table th {
            background: #1977cc !important;

            color: #ffffff !important;

            padding: 13px 12px !important;

            border: none !important;

            font-size: 13px;

            font-weight: 600;

            white-space: nowrap;
        }


        .dashboard-table td {
            padding: 12px !important;

            vertical-align: middle;

            color: #444;

            border-color: #e5e9f0 !important;

            font-size: 13px;
        }


        .dashboard-table tbody tr:hover td {
            background: #f5faff !important;
        }


        /* =========================================
           PATIENT COUNT
        ========================================= */

        .patient-count {
            display: inline-block;

            background: #e8f4fc;

            color: #1977cc;

            padding: 5px 10px;

            border-radius: 20px;

            font-size: 12px;

            font-weight: 600;
        }


        /* =========================================
           QUICK ACTIONS
        ========================================= */

        .quick-action {
            display: flex;

            align-items: center;

            gap: 14px;

            padding: 13px;

            border: 1px solid #e5e9f0;

            border-radius: 10px;

            margin-bottom: 12px;

            text-decoration: none;

            color: #2c4964;

            transition: 0.25s ease;
        }


        .quick-action:hover {
            background: #e8f4fc;

            border-color: #1977cc;

            color: #1977cc;
        }


        .quick-action-icon {
            width: 42px;
            height: 42px;

            border-radius: 9px;

            background: #e8f4fc;

            color: #1977cc;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 19px;
        }


        .quick-action span {
            font-size: 14px;

            font-weight: 600;
        }


        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 768px) {

            .page-heading h2 {
                font-size: 28px;
            }

            .dashboard-card {
                padding: 18px;
            }

            .dashboard-card-header {
                flex-direction: column;

                align-items: flex-start;

                gap: 10px;
            }
        }

    </style>

</asp:Content>



<asp:Content ID="Content2"
    ContentPlaceHolderID="ContentPlaceHolder1"
    runat="server">


    <div class="dashboard-page">


        <!-- =========================================
             PAGE HEADING
        ========================================= -->

        <div class="page-heading">

            <h2>
                Dashboard
            </h2>

            <p>
                Welcome to Medilab Hospital Management System
            </p>

        </div>



        <!-- =========================================
             STATISTICS
        ========================================= -->

        <div class="row g-4 mb-4">


            <!-- TOTAL PATIENTS -->

            <div class="col-xl-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-icon">

                        <i class="bi bi-people"></i>

                    </div>

                    <h6>
                        Total Patients
                    </h6>

                    <h3>

                        <asp:Label
                            ID="lblPatients"
                            runat="server"
                            Text="0">
                        </asp:Label>

                    </h3>

                </div>

            </div>



            <!-- TOTAL APPOINTMENTS -->

            <div class="col-xl-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-icon">

                        <i class="bi bi-calendar-check"></i>

                    </div>

                    <h6>
                        Total Appointments
                    </h6>

                    <h3>

                        <asp:Label
                            ID="lblAppointments"
                            runat="server"
                            Text="0">
                        </asp:Label>

                    </h3>

                </div>

            </div>



            <!-- TOTAL DOCTORS -->

            <div class="col-xl-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-icon">

                        <i class="bi bi-person-badge"></i>

                    </div>

                    <h6>
                        Total Doctors
                    </h6>

                    <h3>

                        <asp:Label
                            ID="lblDoctors"
                            runat="server"
                            Text="0">
                        </asp:Label>

                    </h3>

                </div>

            </div>



            <!-- TOTAL DEPARTMENTS -->

            <div class="col-xl-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-icon">

                        <i class="bi bi-building"></i>

                    </div>

                    <h6>
                        Departments
                    </h6>

                    <h3>

                        <asp:Label
                            ID="lblDepartments"
                            runat="server"
                            Text="0">
                        </asp:Label>

                    </h3>

                </div>

            </div>

        </div>



        <!-- =========================================
             REGISTERED PATIENTS + QUICK ACTIONS
        ========================================= -->

        <div class="row g-4">


            <!-- =====================================
                 RECENT REGISTERED PATIENTS
            ====================================== -->

            <div class="col-lg-8">

                <div class="dashboard-card">


                    <!-- CARD HEADER -->

                    <div class="dashboard-card-header">

                        <h4>

                            <i class="bi bi-people"></i>

                            Recent Registered Patients

                        </h4>


                        <a href="Patients.aspx"
                           class="view-all">

                            View All

                        </a>

                    </div>



                    <!-- PATIENT TABLE -->

                    <div class="table-responsive">

                       <asp:GridView
    ID="gvPatients"
    runat="server"
    AutoGenerateColumns="False"
    CssClass="table table-hover dashboard-table"
    Width="100%"
    EmptyDataText="No patients registered yet.">

    <Columns>

        <asp:BoundField
            DataField="PatientId"
            HeaderText="ID" />

        <asp:BoundField
            DataField="FullName"
            HeaderText="Full Name" />

        <asp:BoundField
            DataField="Email"
            HeaderText="Email" />

        <asp:BoundField
            DataField="Mobile"
            HeaderText="Mobile" />

        <asp:BoundField
            DataField="Gender"
            HeaderText="Gender" />

        <asp:BoundField
            DataField="Address"
            HeaderText="Address" />

    </Columns>

</asp:GridView>
                    </div>

                </div>

            </div>



            <!-- =====================================
                 QUICK ACTIONS
            ====================================== -->

            <div class="col-lg-4">

                <div class="dashboard-card">


                    <div class="dashboard-card-header">

                        <h4>

                            <i class="bi bi-lightning-charge"></i>

                            Quick Actions

                        </h4>

                    </div>



                    <!-- PATIENTS -->

                    <a href="Patients.aspx"
                       class="quick-action">

                        <div class="quick-action-icon">

                            <i class="bi bi-people"></i>

                        </div>

                        <span>
                            Manage Patients
                        </span>

                    </a>



                    <!-- APPOINTMENTS -->

                    <a href="Appointments.aspx"
                       class="quick-action">

                        <div class="quick-action-icon">

                            <i class="bi bi-calendar-check"></i>

                        </div>

                        <span>
                            Manage Appointments
                        </span>

                    </a>



                    <!-- DOCTORS -->

                    <a href="Doctors.aspx"
                       class="quick-action">

                        <div class="quick-action-icon">

                            <i class="bi bi-person-badge"></i>

                        </div>

                        <span>
                            Manage Doctors
                        </span>

                    </a>



                    <!-- DEPARTMENTS -->

                    <a href="Departments.aspx"
                       class="quick-action">

                        <div class="quick-action-icon">

                            <i class="bi bi-building"></i>

                        </div>

                        <span>
                            Manage Departments
                        </span>

                    </a>



                    <!-- ENQUIRIES -->

                    <a href="Enquiries.aspx"
                       class="quick-action">

                        <div class="quick-action-icon">

                            <i class="bi bi-envelope"></i>

                        </div>

                        <span>
                            View Enquiries
                        </span>

                    </a>


                </div>

            </div>

        </div>


    </div>

</asp:Content>