<%@ Page Title="Patient Dashboard" Language="C#" MasterPageFile="~/Site1.master"
    AutoEventWireup="true"
    CodeBehind="PatientDashboard.aspx.cs"
    Inherits="Hospital_Management_System_01.PatientDashboard" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">

    <style>

        .dashboard-section {
            padding: 120px 0;
            background: #f8f9fa;
            min-height: 650px;
        }

        .dashboard-card {
            background: white;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
            text-align: center;
        }

        .dashboard-card h2 {
            color: #2c4964;
            font-weight: 700;
        }

        .dashboard-card p {
            color: #777;
        }

    </style>

</asp:Content>


<asp:Content ID="Content3"
    ContentPlaceHolderID="ContentPlaceHolder2"
    runat="server">

    <main class="main">

        <section class="dashboard-section">

            <div class="container">

                <div class="row justify-content-center">

                    <div class="col-lg-8">

                        <div class="dashboard-card">

                            <h2>
                                Welcome,
                                <asp:Label
                                    ID="lblPatientName"
                                    runat="server">
                                </asp:Label>
                            </h2>

                            <p>
                                Welcome to your Patient Dashboard.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </main>

</asp:Content>


<asp:Content ID="Content4"
    ContentPlaceHolderID="ContentPlaceHolder3"
    runat="server">

</asp:Content>