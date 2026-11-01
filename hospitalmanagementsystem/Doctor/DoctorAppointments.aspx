<%@ Page Title="Doctor Appointments" Language="C#" MasterPageFile="~/Doctor/DoctorMaster.master" AutoEventWireup="true" CodeBehind="DoctorAppointments.aspx.cs" Inherits="Hospital_Management_System_01.Doctor.DoctorAppointments" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">

    <div style="padding:30px;">

        <h2>Doctor Appointments</h2>

        <asp:GridView ID="GridViewAppointments" runat="server"
            AutoGenerateColumns="False"
            Width="100%"
            DataKeyNames="AppointmentId"
            OnRowEditing="GridViewAppointments_RowEditing"
            OnRowCancelingEdit="GridViewAppointments_RowCancelingEdit"
            OnRowUpdating="GridViewAppointments_RowUpdating"
            OnRowDeleting="GridViewAppointments_RowDeleting"
            CellPadding="6"
            BorderWidth="1">

            <Columns>

                <asp:BoundField DataField="AppointmentId"
                    HeaderText="AppointmentId" ReadOnly="True" />

                <asp:BoundField DataField="PatientName"
                    HeaderText="PatientName" />

                <asp:BoundField DataField="DoctorName"
                    HeaderText="DoctorName" />

                <asp:BoundField DataField="Department"
                    HeaderText="Department" />

                <asp:BoundField DataField="AppointmentDate"
                    HeaderText="AppointmentDate"
                    DataFormatString="{0:MM/dd/yyyy}" />

                <asp:BoundField DataField="AppointmentTime"
                    HeaderText="AppointmentTime" />

                <asp:BoundField DataField="Status"
                    HeaderText="Status" />

                <asp:CommandField ShowEditButton="True"
                    ShowDeleteButton="True"
                    EditText="Edit"
                    DeleteText="Delete"
                    UpdateText="Update"
                    CancelText="Cancel" />

            </Columns>

        </asp:GridView>

    </div>

</asp:Content>
