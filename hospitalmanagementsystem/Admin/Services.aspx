<%@ Page Title="Services"
    Language="C#"
    MasterPageFile="~/Admin/AdminMaster.Master"
    AutoEventWireup="true"
    CodeBehind="Services.aspx.cs"
    Inherits="Hospital_Management_System_01.Services" %>

<asp:Content ID="Content1"
    ContentPlaceHolderID="head"
    runat="server">
</asp:Content>

<asp:Content ID="Content2"
    ContentPlaceHolderID="ContentPlaceHolder1"
    runat="server">

    <div class="page-title">
        Services
    </div>

    <div class="welcome">
        Manage Hospital Services
    </div>

    <div class="dashboard-box">

        <div class="box-title">
            Add Service
        </div>

        <div class="row">

            <div class="col-md-6 mb-3">

                <label>Service Name</label>

                <asp:TextBox ID="txtServiceName"
                    runat="server"
                    CssClass="form-control"
                    placeholder="Enter service name">
                </asp:TextBox>

            </div>

            <div class="col-md-6 mb-3">

                <label>Description</label>

                <asp:TextBox ID="txtDescription"
                    runat="server"
                    CssClass="form-control"
                    placeholder="Enter description">
                </asp:TextBox>

            </div>

        </div>

        <asp:Button ID="btnAddService"
            runat="server"
            Text="Add Service"
            CssClass="btn btn-primary"
            OnClick="btnAddService_Click" />

        <asp:Button ID="btnClear"
            runat="server"
            Text="Clear"
            CssClass="btn btn-secondary ms-2"
            OnClick="btnClear_Click" />

        <br />
        <br />

        <asp:Label ID="lblMessage"
            runat="server">
        </asp:Label>

    </div>


    <div class="dashboard-box">

        <div class="box-title">
            Service List
        </div>

        <div class="table-responsive">

            <asp:GridView ID="GridViewServices"
                runat="server"
                AutoGenerateColumns="False"
                CssClass="table table-hover"
                EmptyDataText="No services found."
                OnRowCommand="GridViewServices_RowCommand">

                <Columns>

                    <asp:BoundField
                        DataField="ServiceId"
                        HeaderText="ID" />

                    <asp:BoundField
                        DataField="ServiceName"
                        HeaderText="Service Name" />

                    <asp:BoundField
                        DataField="Description"
                        HeaderText="Description" />

                    <asp:TemplateField HeaderText="Action">

                        <ItemTemplate>

                            <asp:LinkButton
                                ID="btnEdit"
                                runat="server"
                                CommandName="EditService"
                                CommandArgument='<%# Eval("ServiceId") %>'
                                CssClass="btn btn-sm btn-primary me-1">
                                Edit
                            </asp:LinkButton>

                            <asp:LinkButton
                                ID="btnDelete"
                                runat="server"
                                CommandName="DeleteService"
                                CommandArgument='<%# Eval("ServiceId") %>'
                                CssClass="btn btn-sm btn-danger"
                                OnClientClick="return confirm('Are you sure you want to delete this service?');">
                                Delete
                            </asp:LinkButton>

                        </ItemTemplate>

                    </asp:TemplateField>

                </Columns>

            </asp:GridView>

        </div>

    </div>

</asp:Content>