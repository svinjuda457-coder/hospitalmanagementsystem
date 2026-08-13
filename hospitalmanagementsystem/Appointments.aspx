<%@ Page Title="Appointments"
    Language="C#"
    MasterPageFile="~/AdminMaster.Master"
    AutoEventWireup="true"
    CodeBehind="Appointments.aspx.cs"
    Inherits="Hospital_Management_System_01.Appointments" %>

<asp:Content ID="Content1"
    ContentPlaceHolderID="head"
    runat="server">

    <style>

        .appointment-page {
            padding: 10px;
        }

        .page-title {
            margin-bottom: 25px;
        }

        .page-title h2 {
            color: #2c4964;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .page-title p {
            color: #777;
            margin: 0;
        }

        .appointment-card {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .form-label {
            color: #2c4964;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .form-control {
            height: 45px;
            border-radius: 5px;
        }

        textarea.form-control {
            height: 100px;
        }

        .add-btn {
            background: #1977cc;
            border: none;
            color: white;
            padding: 12px 35px;
            border-radius: 5px;
            font-weight: 600;
        }

        .add-btn:hover {
            background: #166ab5;
        }

        .validation-error {
            color: red;
            font-size: 13px;
            display: block;
            margin-top: 5px;
        }

        .validation-summary {
            background: #fff3f3;
            border: 1px solid #ffcccc;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .message {
            display: block;
            margin-top: 15px;
            text-align: center;
            font-weight: 600;
        }

        .appointment-list-card {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }

        .list-title {
            margin-bottom: 20px;
        }

        .list-title h3 {
            color: #2c4964;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .list-title p {
            color: #777;
        }

        .appointment-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .appointment-grid th {
            background: #1977cc;
            color: white;
            padding: 12px;
            text-align: center;
            font-weight: 600;
        }

        .appointment-grid td {
            padding: 12px;
            text-align: center;
            vertical-align: middle;
        }

        .appointment-grid tr:nth-child(even) {
            background: #f8f9fa;
        }

        .appointment-grid tr:hover {
            background: #eef6ff;
        }

    </style>

</asp:Content>


<asp:Content ID="Content3"
    ContentPlaceHolderID="ContentPlaceHolder1"
    runat="server">

    <div class="appointment-page">

        <!-- PAGE TITLE -->

        <div class="page-title">

            <h2>Appointments</h2>

            <p>
                Add and manage patient appointments
            </p>

        </div>


        <!-- ADD APPOINTMENT -->

        <div class="appointment-card">

            <asp:ValidationSummary
                ID="ValidationSummary1"
                runat="server"
                ForeColor="Red"
                HeaderText="Please fix the following errors:"
                DisplayMode="BulletList"
                CssClass="validation-summary" />


            <div class="row gy-4">


                <!-- PATIENT -->

                <div class="col-md-6">

                    <label class="form-label">
                        Patient
                    </label>

                    <asp:TextBox
                        ID="txtPatient"
                        runat="server"
                        CssClass="form-control"
                        placeholder="Enter patient name">
                    </asp:TextBox>

                    <asp:RequiredFieldValidator
                        ID="rfvPatient"
                        runat="server"
                        ControlToValidate="txtPatient"
                        ErrorMessage="Patient name is required."
                        CssClass="validation-error"
                        Display="Dynamic">
                    </asp:RequiredFieldValidator>

                </div>


                <!-- DOCTOR -->

                <div class="col-md-6">

                    <label class="form-label">
                        Doctor
                    </label>

                    <asp:TextBox
                        ID="txtDoctor"
                        runat="server"
                        CssClass="form-control"
                        placeholder="Enter doctor name">
                    </asp:TextBox>

                    <asp:RequiredFieldValidator
                        ID="rfvDoctor"
                        runat="server"
                        ControlToValidate="txtDoctor"
                        ErrorMessage="Doctor name is required."
                        CssClass="validation-error"
                        Display="Dynamic">
                    </asp:RequiredFieldValidator>

                </div>


                <!-- DATE -->

                <div class="col-md-6">

                    <label class="form-label">
                        Appointment Date
                    </label>

                    <asp:TextBox
                        ID="txtAppointmentDate"
                        runat="server"
                        CssClass="form-control"
                        TextMode="Date">
                    </asp:TextBox>

                    <asp:RequiredFieldValidator
                        ID="rfvAppointmentDate"
                        runat="server"
                        ControlToValidate="txtAppointmentDate"
                        ErrorMessage="Appointment date is required."
                        CssClass="validation-error"
                        Display="Dynamic">
                    </asp:RequiredFieldValidator>

                </div>


                <!-- TIME -->

                <div class="col-md-6">

                    <label class="form-label">
                        Appointment Time
                    </label>

                    <asp:TextBox
                        ID="txtAppointmentTime"
                        runat="server"
                        CssClass="form-control"
                        TextMode="Time">
                    </asp:TextBox>

                    <asp:RequiredFieldValidator
                        ID="rfvAppointmentTime"
                        runat="server"
                        ControlToValidate="txtAppointmentTime"
                        ErrorMessage="Appointment time is required."
                        CssClass="validation-error"
                        Display="Dynamic">
                    </asp:RequiredFieldValidator>

                </div>


                <!-- REASON -->

                <div class="col-md-12">

                    <label class="form-label">
                        Reason
                    </label>

                    <asp:TextBox
                        ID="txtReason"
                        runat="server"
                        CssClass="form-control"
                        TextMode="MultiLine"
                        Rows="4"
                        placeholder="Enter appointment reason">
                    </asp:TextBox>

                    <asp:RequiredFieldValidator
                        ID="rfvReason"
                        runat="server"
                        ControlToValidate="txtReason"
                        ErrorMessage="Appointment reason is required."
                        CssClass="validation-error"
                        Display="Dynamic">
                    </asp:RequiredFieldValidator>

                </div>


                <!-- BUTTON -->

                <div class="col-md-12 text-center">

                    <asp:Button
                        ID="btnAddAppointment"
                        runat="server"
                        Text="Add Appointment"
                        CssClass="add-btn"
                        CausesValidation="True"
                        OnClick="btnAddAppointment_Click" />

                </div>


                <!-- MESSAGE -->

                <div class="col-md-12">

                    <asp:Label
                        ID="lblMessage"
                        runat="server"
                        CssClass="message">
                    </asp:Label>

                </div>

            </div>

        </div>


        <!-- APPOINTMENT LIST -->

        <div class="appointment-list-card">

            <div class="list-title">

                <h3>Appointment List</h3>

                <p>
                    Recently added appointments
                </p>

            </div>


            <div class="table-responsive">

                <asp:GridView
                    ID="gvAppointments"
                    runat="server"
                    AutoGenerateColumns="False"
                    CssClass="appointment-grid"
                    Width="100%"
                    EmptyDataText="No appointments found.">

                    <Columns>

                        <asp:BoundField
                            DataField="AppointmentId"
                            HeaderText="ID" />

                        <asp:BoundField
                            DataField="Patient"
                            HeaderText="Patient" />

                        <asp:BoundField
                            DataField="Doctor"
                            HeaderText="Doctor" />

                        <asp:BoundField
                            DataField="AppointmentDate"
                            HeaderText="Date"
                            DataFormatString="{0:dd-MM-yyyy}" />

                        <asp:BoundField
                            DataField="AppointmentTime"
                            HeaderText="Time" />

                        <asp:BoundField
                            DataField="Reason"
                            HeaderText="Reason" />

                    </Columns>

                </asp:GridView>

            </div>

        </div>

    </div>

</asp:Content>