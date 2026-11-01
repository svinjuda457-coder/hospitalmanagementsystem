<%@ Page Title="Admin Dashboard"
    Language="C#"
    MasterPageFile="~/Admin/AdminMaster.Master"
    AutoEventWireup="true"
    CodeBehind="AdminDashboard.aspx.cs"
    Inherits="Hospital_Management_System_01.AdminDashboard" %>

<asp:Content ID="Content1"
    ContentPlaceHolderID="head"
    runat="server">
</asp:Content>

<asp:Content ID="Content2"
    ContentPlaceHolderID="ContentPlaceHolder1"
    runat="server">

    <div class="page-title">
        Dashboard
    </div>

    <div class="welcome">
        Welcome to Medilab Hospital Admin Panel
    </div>

    <div class="row">

        <div class="col-md-3 mb-3">
            <div class="dashboard-card">

                <i class="bi bi-people-fill"></i>

                <div class="dashboard-number">
                    <asp:Label ID="lblTotalPatients"
                        runat="server"
                        Text="0">
                    </asp:Label>
                </div>

                <div class="dashboard-label">
                    Total Patients
                </div>

            </div>
        </div>


        <div class="col-md-3 mb-3">
            <div class="dashboard-card">

                <i class="bi bi-person-badge-fill"></i>

                <div class="dashboard-number">
                    <asp:Label ID="lblTotalDoctors"
                        runat="server"
                        Text="18">
                    </asp:Label>
                </div>

                <div class="dashboard-label">
                    Total Doctors
                </div>

            </div>
        </div>


        <div class="col-md-3 mb-3">
            <div class="dashboard-card">

                <i class="bi bi-calendar-check-fill"></i>

                <div class="dashboard-number">
                    <asp:Label ID="lblAppointments"
                        runat="server"
                        Text="0">
                    </asp:Label>
                </div>

                <div class="dashboard-label">
                    Appointments Today
                </div>

            </div>
        </div>


        <div class="col-md-3 mb-3">
            <div class="dashboard-card">

                <i class="bi bi-hospital-fill"></i>

                <div class="dashboard-number">
                    <asp:Label ID="lblDepartments"
                        runat="server"
                        Text="8">
                    </asp:Label>
                </div>

                <div class="dashboard-label">
                    Departments
                </div>

            </div>
        </div>

    </div>


    <div class="dashboard-box">

        <div class="box-title">
            Recent Registered Patients
        </div>

        <div class="table-responsive">

            <asp:GridView ID="GridViewPatients"
                runat="server"
                AutoGenerateColumns="False"
                CssClass="table table-hover"
                EmptyDataText="No patients registered yet."
                OnRowCommand="GridViewPatients_RowCommand">

                <Columns>

                    <asp:BoundField
                        DataField="Id"
                        HeaderText="#" />

                    <asp:BoundField
                        DataField="Name"
                        HeaderText="Patient Name" />

                    <asp:BoundField
                        DataField="Gender"
                        HeaderText="Gender" />

                    <asp:BoundField
                        DataField="Email"
                        HeaderText="Email" />

                    <asp:BoundField
                        DataField="City"
                        HeaderText="City" />

                    <asp:BoundField
                        DataField="Mobile"
                        HeaderText="Mobile" />

                    <asp:TemplateField HeaderText="Action">

                        <ItemTemplate>

                            <asp:LinkButton
                                ID="btnEdit"
                                runat="server"
                                CommandName="EditPatient"
                                CommandArgument='<%# Eval("Id") %>'
                                CssClass="btn btn-sm btn-primary me-1">
                                Edit
                            </asp:LinkButton>

                            <asp:LinkButton
                                ID="btnDelete"
                                runat="server"
                                CommandName="DeletePatient"
                                CommandArgument='<%# Eval("Id") %>'
                                CssClass="btn btn-sm btn-danger"
                                OnClientClick="return confirm('Are you sure you want to delete this patient?');">
                                Delete
                            </asp:LinkButton>

                        </ItemTemplate>

                    </asp:TemplateField>

                </Columns>

            </asp:GridView>

        </div>

    </div>

</asp:Content>