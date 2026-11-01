<%--<%@ Page Title="Patient Dashboard" Language="C#" MasterPageFile="~/Patient/PatientMaster.master"
    AutoEventWireup="true" CodeBehind="PatientDashboard.aspx.cs"
    Inherits="Hospital_Management_System_01.Patient.PatientDashboard" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>

<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">

    <div class="page-title">
        Patient Dashboard
    </div>

    <div class="welcome">
        Welcome, <asp:Label ID="lblPatientName" runat="server"></asp:Label>
    </div>

    <div class="row">

        <div class="col-md-3 mb-3">
            <div class="dashboard-card">
                <i class="bi bi-calendar-check-fill"></i>
                <div class="dashboard-number">
                    <asp:Label ID="lblTotalAppt" runat="server" Text="0"></asp:Label>
                </div>
                <div class="dashboard-label">
                    Total Appointments
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="dashboard-card">
                <i class="bi bi-calendar-event"></i>
                <div class="dashboard-number">
                    <asp:Label ID="lblUpcoming" runat="server" Text="0"></asp:Label>
                </div>
                <div class="dashboard-label">
                    Upcoming
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="dashboard-card">
                <i class="bi bi-check-circle-fill"></i>
                <div class="dashboard-number">
                    <asp:Label ID="lblCompleted" runat="server" Text="0"></asp:Label>
                </div>
                <div class="dashboard-label">
                    Completed
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="dashboard-card">
                <i class="bi bi-capsule"></i>
                <div class="dashboard-number">
                    <asp:Label ID="lblPrescriptions" runat="server" Text="0"></asp:Label>
                </div>
                <div class="dashboard-label">
                    Prescriptions
                </div>
            </div>
        </div>

    </div>

    <div class="dashboard-box">

        <div class="box-title">
            My Recent Appointments
        </div>

        <div class="table-responsive">

            <asp:GridView ID="GridViewAppointments"
                runat="server"
                AutoGenerateColumns="False"
                CssClass="table table-hover"
                EmptyDataText="No appointments found.">

                <Columns>
                    <asp:BoundField DataField="Id" HeaderText="#" />
                    <asp:BoundField DataField="DoctorName" HeaderText="Doctor" />
                    <asp:BoundField DataField="AppointmentDate" HeaderText="Date" />
                    <asp:BoundField DataField="AppointmentTime" HeaderText="Time" />
                    <asp:BoundField DataField="Status" HeaderText="Status" />
                </Columns>

            </asp:GridView>

        </div>

    </div>

</asp:Content>--%>


<%@ Page Title="Patient Dashboard" Language="C#" MasterPageFile="~/Patient/PatientMaster.master"
    AutoEventWireup="true" CodeBehind="PatientDashboard.aspx.cs"
    Inherits="Hospital_Management_System_01.Patient.PatientDashboard" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
    <style>
        /* ડૉક્ટર પેનલ જેવા જ પ્રીમિયમ લુક માટે કસ્ટમ સ્ટાઇલ */
        .dashboard-card-custom {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .dashboard-card-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }
        .card-icon-wrapper {
            font-size: 2rem;
            margin-bottom: 12px;
            display: inline-block;
        }
        .dashboard-box-custom {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.05);
            padding: 24px;
            margin-top: 25px;
        }
        .custom-table th {
            background-color: #f8f9fa !important;
            color: #333333;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }
    </style>
</asp:Content>

<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">

    <!-- પેજ ટાઈટલ અને વેલકમ મેસેજ -->
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1">Patient Dashboard</h2>
        <p class="text-muted">Welcome, <asp:Label ID="lblPatientName" runat="server" Font-Bold="true" ForeColor="#007bff"></asp:Label></p>
    </div>

    <!-- ૪ સ્ટેટ્સ કાર્ડ્સની ગોઠવણી -->
    <div class="row">

        <!-- Total Appointments Card -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="dashboard-card-custom text-center p-4 h-100">
                <div class="card-icon-wrapper text-primary">
                    <i class="bi bi-calendar-check-fill"></i>
                </div>
                <h2 class="display-6 fw-bold text-primary mb-1">
                    <asp:Label ID="lblTotalAppt" runat="server" Text="0"></asp:Label>
                </h2>
                <span class="text-muted fw-medium small d-block">Total Appointments</span>
            </div>
        </div>

        <!-- Upcoming Card -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="dashboard-card-custom text-center p-4 h-100">
                <div class="card-icon-wrapper text-info">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <h2 class="display-6 fw-bold text-info mb-1">
                    <asp:Label ID="lblUpcoming" runat="server" Text="0"></asp:Label>
                </h2>
                <span class="text-muted fw-medium small d-block">Upcoming</span>
            </div>
        </div>

        <!-- Completed Card -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="dashboard-card-custom text-center p-4 h-100">
                <div class="card-icon-wrapper text-success">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <h2 class="display-6 fw-bold text-success mb-1">
                    <asp:Label ID="lblCompleted" runat="server" Text="0"></asp:Label>
                </h2>
                <span class="text-muted fw-medium small d-block">Completed</span>
            </div>
        </div>

        <!-- Prescriptions Card -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="dashboard-card-custom text-center p-4 h-100">
                <div class="card-icon-wrapper text-warning">
                    <i class="bi bi-capsule"></i>
                </div>
                <h2 class="display-6 fw-bold text-warning mb-1">
                    <asp:Label ID="lblPrescriptions" runat="server" Text="0"></asp:Label>
                </h2>
                <span class="text-muted fw-medium small d-block">Prescriptions</span>
            </div>
        </div>

    </div>

    <!-- તાજેતરના એપોઇન્ટમેન્ટ્સનું પ્રોફેશનલ ટેબલ બોક્સ -->
    <div class="dashboard-box-custom">

        <h5 class="fw-bold text-dark mb-4">My Recent Appointments</h5>

        <div class="table-responsive">
            <asp:GridView ID="GridViewAppointments"
                runat="server"
                AutoGenerateColumns="False"
                CssClass="table table-hover custom-table align-middle mb-0"
                EmptyDataText="No appointments found."
                GridLines="None">

                <Columns>
                    <asp:BoundField DataField="Id" HeaderText="#" ItemStyle-Width="8%" />
                    <asp:BoundField DataField="DoctorName" HeaderText="Doctor" />
                    <asp:BoundField DataField="AppointmentDate" HeaderText="Date" DataFormatString="{0:dd/MM/yyyy}" />
                    <asp:BoundField DataField="AppointmentTime" HeaderText="Time" />
                    <asp:BoundField DataField="Status" HeaderText="Status" />
                </Columns>

            </asp:GridView>
        </div>

    </div>

</asp:Content>
