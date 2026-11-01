<%@ Page Title="Reports"
    Language="C#"
    MasterPageFile="~/Admin/AdminMaster.Master"
    AutoEventWireup="true"
    CodeBehind="Reports.aspx.cs"
    Inherits="Hospital_Management_System_01.Reports" %>

<asp:Content ID="Content1"
    ContentPlaceHolderID="head"
    runat="server">
</asp:Content>

<asp:Content ID="Content2"
    ContentPlaceHolderID="ContentPlaceHolder1"
    runat="server">

    <div class="page-title">
        Reports
    </div>

    <div class="welcome">
        Hospital Management Reports
    </div>


    <div class="row">

        <div class="col-md-4 mb-4">

            <div class="dashboard-card">

                <i class="bi bi-people-fill"></i>

                <div class="dashboard-number">
                    <asp:Label ID="lblPatients"
                        runat="server"
                        Text="0">
                    </asp:Label>
                </div>

                <div class="dashboard-label">
                    Total Patients
                </div>

            </div>

        </div>


        <div class="col-md-4 mb-4">

            <div class="dashboard-card">

                <i class="bi bi-grid-fill"></i>

                <div class="dashboard-number">
                    <asp:Label ID="lblDepartments"
                        runat="server"
                        Text="0">
                    </asp:Label>
                </div>

                <div class="dashboard-label">
                    Total Departments
                </div>

            </div>

        </div>


        <div class="col-md-4 mb-4">

            <div class="dashboard-card">

                <i class="bi bi-gear-fill"></i>

                <div class="dashboard-number">
                    <asp:Label ID="lblServices"
                        runat="server"
                        Text="0">
                    </asp:Label>
                </div>

                <div class="dashboard-label">
                    Total Services
                </div>

            </div>

        </div>

    </div>


    <div class="dashboard-box">

        <div class="box-title">
            Patient Report
        </div>

        <div class="table-responsive">

            <asp:GridView ID="GridViewReport"
                runat="server"
                AutoGenerateColumns="False"
                CssClass="table table-hover"
                EmptyDataText="No patient records found.">

                <Columns>

                    <asp:BoundField
                        DataField="Id"
                        HeaderText="ID" />

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

                </Columns>

            </asp:GridView>

        </div>

    </div>

</asp:Content>