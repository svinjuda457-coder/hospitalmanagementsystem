<%@ Page Title="Appointment History" Language="C#" MasterPageFile="~/Patient/PatientMaster.master" AutoEventWireup="true" CodeBehind="AppointmentHistory.aspx.cs" Inherits="Hospital_Management_System_01.Patient.AppointmentHistory" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">

    <div style="padding:30px;">

        <h2>Appointment History</h2>

        <br />

        <asp:GridView ID="GridViewHistory" runat="server"
            AutoGenerateColumns="true"
            Width="100%">
        </asp:GridView>

    </div>

</asp:Content>