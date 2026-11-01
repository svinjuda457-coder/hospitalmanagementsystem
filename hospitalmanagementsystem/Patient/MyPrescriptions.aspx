<%@ Page Title="My Prescriptions" Language="C#" MasterPageFile="~/Patient/PatientMaster.master" AutoEventWireup="true" CodeBehind="MyPrescriptions.aspx.cs" Inherits="Hospital_Management_System_01.Patient.MyPrescriptions" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">

    <div style="padding:30px;">

        <h2>My Prescriptions</h2>

        <br />

        <asp:GridView ID="GridViewPrescriptions" runat="server"
            AutoGenerateColumns="true"
            Width="100%">
        </asp:GridView>

    </div>

</asp:Content>