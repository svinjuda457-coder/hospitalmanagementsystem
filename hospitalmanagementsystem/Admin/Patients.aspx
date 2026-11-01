<%@ Page Title="Patients"
    Language="C#"
    MasterPageFile="~/Admin/AdminMaster.Master"
    AutoEventWireup="true"
    CodeBehind="Patients.aspx.cs"
    Inherits="Hospital_Management_System_01.Patients" %>

<asp:Content ID="Content1"
    ContentPlaceHolderID="head"
    runat="server">
</asp:Content>

<asp:Content ID="Content2"
    ContentPlaceHolderID="ContentPlaceHolder1"
    runat="server">

    <div class="page-title">
        Patients
    </div>

    <div class="welcome">
        Manage Registered Patients
    </div>

    <div class="dashboard-box">

        <div class="box-title">
            Patient List
        </div>

        <div class="table-responsive">

            <asp:GridView ID="GridViewPatients"
                runat="server"
                AutoGenerateColumns="False"
                CssClass="table table-hover"
                EmptyDataText="No patients found."
                OnRowCommand="GridViewPatients_RowCommand">

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
                        DataField="Address"
                        HeaderText="Address" />

                    <asp:BoundField
                        DataField="Mobile"
                        HeaderText="Mobile" />

                    <asp:TemplateField HeaderText="Action">

                        <ItemTemplate>

                            <asp:LinkButton
                                ID="btnEdit"
                                runat="server"
                                CommandName="EditPatient"
                                CommandArgument='<%# Eval("Id") %>'
                                CssClass="btn btn-sm btn-primary me-1">
                                Edit
                            </asp:LinkButton>

                            <asp:LinkButton
                                ID="btnDelete"
                                runat="server"
                                CommandName="DeletePatient"
                                CommandArgument='<%# Eval("Id") %>'
                                CssClass="btn btn-sm btn-danger"
                                OnClientClick="return confirm('Are you sure you want to delete this patient?');">
                                Delete
                            </asp:LinkButton>

                        </ItemTemplate>

                    </asp:TemplateField>

                </Columns>

            </asp:GridView>

        </div>

    </div>

</asp:Content>