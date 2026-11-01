<%@ Page Title="Doctor Prescriptions" Language="C#" MasterPageFile="~/Doctor/DoctorMaster.master" AutoEventWireup="true" CodeBehind="DoctorPrescriptions.aspx.cs" Inherits="Hospital_Management_System_01.Doctor.DoctorPrescriptions" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">

    <div style="padding:30px;">

        <h2>Doctor Prescriptions</h2>

        <p>
            Patient Name:
            <asp:TextBox ID="txtPatientName" runat="server"></asp:TextBox>
        </p>

        <p>
            Medicine:
            <asp:TextBox ID="txtMedicine" runat="server"></asp:TextBox>
        </p>

        <p>
            Dosage:
            <asp:TextBox ID="txtDosage" runat="server"></asp:TextBox>
        </p>

        <p>
            Instructions:
            <asp:TextBox ID="txtInstructions" runat="server"></asp:TextBox>
        </p>

        <asp:Button ID="btnSave" runat="server"
            Text="Save Prescription"
            OnClick="btnSave_Click" />

        <br /><br />

        <asp:GridView ID="GridViewPrescriptions" runat="server"
            AutoGenerateColumns="false"
            Width="100%"
            DataKeyNames="PrescriptionId"
            OnRowEditing="GridViewPrescriptions_RowEditing"
            OnRowCancelingEdit="GridViewPrescriptions_RowCancelingEdit"
            OnRowUpdating="GridViewPrescriptions_RowUpdating"
            OnRowDeleting="GridViewPrescriptions_RowDeleting"
            CellPadding="6"
            BorderWidth="1">
            
            <Columns>
                <asp:BoundField DataField="PrescriptionId" HeaderText="Prescription ID" ReadOnly="true" />
                <asp:BoundField DataField="PatientName" HeaderText="Patient Name" />
                <asp:BoundField DataField="Medicine" HeaderText="Medicine" />
                <asp:BoundField DataField="Dosage" HeaderText="Dosage" />
                <asp:BoundField DataField="Instructions" HeaderText="Instructions" />
                
                <asp:CommandField ShowEditButton="true" ShowDeleteButton="true"
                    EditText="Edit" UpdateText="Update" CancelText="Cancel" DeleteText="Delete" />
            </Columns>

        </asp:GridView>

    </div>

</asp:Content>
