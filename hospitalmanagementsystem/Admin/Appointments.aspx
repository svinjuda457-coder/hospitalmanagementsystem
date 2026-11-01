<%@ Page Title="Appointments"
    Language="C#"
    MasterPageFile="~/Admin/AdminMaster.Master"
    AutoEventWireup="true"
    CodeBehind="Appointments.aspx.cs"
    Inherits="Hospital_Management_System_01.Appointments" %>

<asp:Content ID="Content1"
    ContentPlaceHolderID="head"
    runat="server">
</asp:Content>

<asp:Content ID="Content2"
    ContentPlaceHolderID="ContentPlaceHolder1"
    runat="server">

    <div class="page-title">
        Appointments
    </div>

    <div class="welcome">
        Manage Patient Appointments
    </div>

    <div class="dashboard-box">

        <div class="box-title">
            Appointment List
        </div>

        <div class="table-responsive">

            <asp:GridView ID="GridViewAppointments"
                runat="server"
                AutoGenerateColumns="False"
                CssClass="table table-hover"
                EmptyDataText="No appointments found."
                OnRowCommand="GridViewAppointments_RowCommand">

                <Columns>

                    <asp:BoundField
                        DataField="AppointmentId"
                        HeaderText="ID" />

                    <asp:BoundField
                        DataField="PatientName"
                        HeaderText="Patient Name" />

                    <asp:BoundField
                        DataField="DoctorName"
                        HeaderText="Doctor" />

                    <asp:BoundField
                        DataField="Department"
                        HeaderText="Department" />

                    <asp:BoundField
                        DataField="AppointmentDate"
                        HeaderText="Date"
                        DataFormatString="{0:dd-MM-yyyy}" />

                    <asp:BoundField
                        DataField="AppointmentTime"
                        HeaderText="Time" />

                    <asp:BoundField
                        DataField="Status"
                        HeaderText="Status" />

                    <asp:TemplateField HeaderText="Action">

                        <ItemTemplate>

                            <asp:LinkButton
                                ID="btnEdit"
                                runat="server"
                                CommandName="EditAppointment"
                                CommandArgument='<%# Eval("AppointmentId") %>'
                                CssClass="btn btn-sm btn-primary me-1">
                                Edit
                            </asp:LinkButton>

                            <asp:LinkButton
                                ID="btnDelete"
                                runat="server"
                                CommandName="DeleteAppointment"
                                CommandArgument='<%# Eval("AppointmentId") %>'
                                CssClass="btn btn-sm btn-danger"
                                OnClientClick="return confirm('Are you sure you want to delete this appointment?');">
                                Delete
                            </asp:LinkButton>

                        </ItemTemplate>

                    </asp:TemplateField>

                </Columns>

            </asp:GridView>

        </div>

    </div>

</asp:Content>