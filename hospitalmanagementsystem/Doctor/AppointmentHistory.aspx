<%@ Page Title="Appointment History" Language="C#" MasterPageFile="~/Doctor/DoctorMaster.master" AutoEventWireup="true" CodeBehind="AppointmentHistory.aspx.cs" Inherits="Hospital_Management_System_01.Doctor.AppointmentHistory" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">

    <div style="padding:30px;">

        <h2>Appointment History</h2>

        <asp:GridView ID="GridViewHistory" runat="server"
            AutoGenerateColumns="False"
            Width="100%"
            DataKeyNames="AppointmentId"
            OnRowEditing="GridViewHistory_RowEditing"
            OnRowCancelingEdit="GridViewHistory_RowCancelingEdit"
            OnRowUpdating="GridViewHistory_RowUpdating"
            OnRowDeleting="GridViewHistory_RowDeleting"
            CellPadding="6"
            BorderWidth="1">

            <Columns>

                <asp:BoundField DataField="AppointmentId" HeaderText="Appointment ID" ReadOnly="True" />
                <asp:BoundField DataField="PatientName" HeaderText="Patient Name" />
                <asp:BoundField DataField="DoctorName" HeaderText="Doctor Name" />
                <asp:BoundField DataField="Department" HeaderText="Department" />
                <asp:BoundField DataField="AppointmentDate" HeaderText="Appointment Date" DataFormatString="{0:MM/dd/yyyy}" />
                <asp:BoundField DataField="AppointmentTime" HeaderText="Appointment Time" />
                <asp:BoundField DataField="Status" HeaderText="Status" />

                <asp:CommandField ShowEditButton="True" ShowDeleteButton="True"
                    EditText="Edit" UpdateText="Update" CancelText="Cancel" DeleteText="Delete" />

            </Columns>

        </asp:GridView>

    </div>

</asp:Content>
