<%@ Page Title="Doctor Dashboard" Language="C#" MasterPageFile="~/Doctor/DoctorMaster.master"
    AutoEventWireup="true" CodeBehind="DoctorDashboard.aspx.cs"
    Inherits="Hospital_Management_System_01.Doctor.DoctorDashboard" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">

    <style>
        .page-title { font-size: 28px; font-weight: 700; color: #1a1a2e; margin-bottom: 8px; }
        .welcome { color: #6c757d; margin-bottom: 25px; font-size: 15px; }
        .dashboard-card {
            background: white; border-radius: 12px; padding: 25px 20px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08); text-align: center;
            border: 1px solid #f0f0f0; height: 100%;
        }
        .dashboard-card i { font-size: 28px; color: #0d6efd; margin-bottom: 12px; display: block; }
        .dashboard-number { font-size: 32px; font-weight: 700; color: #0d6efd; margin-bottom: 6px; }
        .dashboard-label { color: #6c757d; font-size: 14px; }
        .box-title { font-size: 18px; font-weight: 600; margin: 30px 0 15px; color: #1a1a2e; }
    </style>

    <div class="page-title">Doctor Dashboard</div>
    <div class="welcome">
        Welcome, <asp:Label ID="lblDoctorName" runat="server"></asp:Label>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="dashboard-card">
                <i class="bi bi-people-fill"></i>
                <div class="dashboard-number">
                    <asp:Label ID="lblPatients" runat="server" Text="0"></asp:Label>
                </div>
                <div class="dashboard-label">Total Patients</div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="dashboard-card">
                <i class="bi bi-calendar-check-fill"></i>
                <div class="dashboard-number">
                    <asp:Label ID="lblAppointments" runat="server" Text="0"></asp:Label>
                </div>
                <div class="dashboard-label">Total Appointments</div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="dashboard-card">
                <i class="bi bi-file-medical-fill"></i>
                <div class="dashboard-number">
                    <asp:Label ID="lblPrescriptions" runat="server" Text="0"></asp:Label>
                </div>
                <div class="dashboard-label">Prescriptions</div>
            </div>
        </div>
    </div>

    <div class="box-title">Recent Appointments</div>
    <div class="table-responsive">
        <asp:GridView ID="GridViewAppointments" runat="server"
            AutoGenerateColumns="False" CssClass="table table-hover"
            EmptyDataText="No appointments yet.">
            <Columns>
                <asp:BoundField DataField="AppointmentId" HeaderText="#" />
                <asp:BoundField DataField="PatientName" HeaderText="Patient" />
                <asp:BoundField DataField="DoctorName" HeaderText="Doctor" />
                <asp:BoundField DataField="Department" HeaderText="Department" />
                <asp:BoundField DataField="AppointmentDate" HeaderText="Date" DataFormatString="{0:dd/MM/yyyy}" />
                <asp:BoundField DataField="AppointmentTime" HeaderText="Time" />
                <asp:BoundField DataField="Status" HeaderText="Status" />
            </Columns>
        </asp:GridView>
    </div>

</asp:Content>

