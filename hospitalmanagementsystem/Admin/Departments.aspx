<%@ Page Title="Departments"
    Language="C#"
    MasterPageFile="~/Admin/AdminMaster.Master"
    AutoEventWireup="true"
    CodeBehind="Departments.aspx.cs"
    Inherits="Hospital_Management_System_01.Departments" %>

<asp:Content ID="Content1"
    ContentPlaceHolderID="head"
    runat="server">
</asp:Content>

<asp:Content ID="Content2"
    ContentPlaceHolderID="ContentPlaceHolder1"
    runat="server">

    <div class="page-title">
        Departments
    </div>

    <div class="welcome">
        Manage Hospital Departments
    </div>

    <div class="dashboard-box">

        <div class="box-title">
            Add Department
        </div>

        <div class="row">

            <div class="col-md-6 mb-3">

                <label>Department Name</label>

                <asp:TextBox ID="txtDepartmentName"
                    runat="server"
                    CssClass="form-control"
                    placeholder="Enter department name">
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


        <asp:Button ID="btnAddDepartment"
            runat="server"
            Text="Add Department"
            CssClass="btn btn-primary"
            OnClick="btnAddDepartment_Click" />


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
            Department List
        </div>

        <div class="table-responsive">

            <asp:GridView ID="GridViewDepartments"
                runat="server"
                AutoGenerateColumns="False"
                CssClass="table table-hover"
                EmptyDataText="No departments found."
                OnRowCommand="GridViewDepartments_RowCommand">

                <Columns>

                    <asp:BoundField
                        DataField="DepartmentId"
                        HeaderText="ID" />

                    <asp:BoundField
                        DataField="DepartmentName"
                        HeaderText="Department Name" />

                    <asp:BoundField
                        DataField="Description"
                        HeaderText="Description" />

                    <asp:TemplateField HeaderText="Action">

                        <ItemTemplate>

                            <asp:LinkButton
                                ID="btnEdit"
                                runat="server"
                                CommandName="EditDepartment"
                                CommandArgument='<%# Eval("DepartmentId") %>'
                                CssClass="btn btn-sm btn-primary me-1">
                                Edit
                            </asp:LinkButton>

                            <asp:LinkButton
                                ID="btnDelete"
                                runat="server"
                                CommandName="DeleteDepartment"
                                CommandArgument='<%# Eval("DepartmentId") %>'
                                CssClass="btn btn-sm btn-danger"
                                OnClientClick="return confirm('Are you sure you want to delete this department?');">
                                Delete
                            </asp:LinkButton>

                        </ItemTemplate>

                    </asp:TemplateField>

                </Columns>

            </asp:GridView>

        </div>

    </div>

</asp:Content>