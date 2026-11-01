<%@ Page Title="Doctor Patients" Language="C#" MasterPageFile="~/Doctor/DoctorMaster.master" AutoEventWireup="true" CodeBehind="DoctorPatients.aspx.cs" Inherits="Hospital_Management_System_01.Doctor.DoctorPatients" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">

    <div style="padding:30px;">

        <h2>Doctor Patients</h2>

        <asp:GridView ID="GridViewPatients" runat="server"
            AutoGenerateColumns="false"
            Width="100%"
            DataKeyNames="PatientId"
            OnRowEditing="GridViewPatients_RowEditing"
            OnRowCancelingEdit="GridViewPatients_RowCancelingEdit"
            OnRowUpdating="GridViewPatients_RowUpdating"
            OnRowDeleting="GridViewPatients_RowDeleting"
            CellPadding="8"
            BorderWidth="1"
            GridLines="None"
            Style="border-collapse: collapse; margin-top: 20px;">
            
            <HeaderStyle BackColor="#1A73E8" ForeColor="White" Font-Bold="true" Height="40px" HorizontalAlign="Left" />
            <RowStyle Height="35px" BorderColor="#E0E0E0" BorderWidth="1px" BorderStyle="Solid" />
            <AlternatingRowStyle BackColor="#F9F9F9" />

            <Columns>
                <asp:BoundField DataField="PatientId" HeaderText="Patient ID" ReadOnly="true" />
                <asp:BoundField DataField="PatientName" HeaderText="Patient Name" />
                <asp:BoundField DataField="Email" HeaderText="Email Address" />
                <asp:BoundField DataField="Mobile" HeaderText="Mobile Number" />
                
                <asp:CommandField ShowEditButton="true" ShowDeleteButton="true"
                    EditText="Edit" UpdateText="Update" CancelText="Cancel" DeleteText="Delete" />
            </Columns>

        </asp:GridView>

    </div>

</asp:Content>
