<%@ Page Title="Doctors"
    Language="C#"
    MasterPageFile="~/Admin/AdminMaster.Master"
    AutoEventWireup="true"
    CodeBehind="Doctors.aspx.cs"
    Inherits="Hospital_Management_System_01.Doctors" %>

<asp:Content ID="Content1"
    ContentPlaceHolderID="head"
    runat="server">
</asp:Content>

<asp:Content ID="Content2"
    ContentPlaceHolderID="ContentPlaceHolder1"
    runat="server">

    <div class="page-title">
        Doctors
    </div>

    <div class="welcome">
        Manage Hospital Doctors
    </div>

    <div class="dashboard-box">

        <div class="box-title">
            Add Doctor
        </div>

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>Doctor Name</label>

                <asp:TextBox ID="txtDoctorName"
                    runat="server"
                    CssClass="form-control"
                    placeholder="Enter doctor name">
                </asp:TextBox>
            </div>


            <div class="col-md-6 mb-3">
                <label>Gender</label>

                <asp:DropDownList ID="ddlGender"
                    runat="server"
                    CssClass="form-control">

                    <asp:ListItem Text="Select Gender"
                        Value="">
                    </asp:ListItem>

                    <asp:ListItem Text="Male"
                        Value="Male">
                    </asp:ListItem>

                    <asp:ListItem Text="Female"
                        Value="Female">
                    </asp:ListItem>

                </asp:DropDownList>
            </div>


            <div class="col-md-6 mb-3">
                <label>Email</label>

                <asp:TextBox ID="txtEmail"
                    runat="server"
                    CssClass="form-control"
                    TextMode="Email"
                    placeholder="Enter email">
                </asp:TextBox>
            </div>


            <div class="col-md-6 mb-3">
                <label>Mobile</label>

                <asp:TextBox ID="txtMobile"
                    runat="server"
                    CssClass="form-control"
                    placeholder="Enter mobile number">
                </asp:TextBox>
            </div>


            <div class="col-md-6 mb-3">
                <label>Specialization</label>

                <asp:TextBox ID="txtSpecialization"
                    runat="server"
                    CssClass="form-control"
                    placeholder="Enter specialization">
                </asp:TextBox>
            </div>

        </div>


        <asp:Button ID="btnAddDoctor"
            runat="server"
            Text="Add Doctor"
            CssClass="btn btn-primary"
            OnClick="btnAddDoctor_Click" />

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
            Doctor List
        </div>

        <div class="table-responsive">

            <asp:GridView ID="GridViewDoctors"
                runat="server"
                AutoGenerateColumns="False"
                CssClass="table table-hover"
                EmptyDataText="No doctors found."
                OnRowCommand="GridViewDoctors_RowCommand">

                <Columns>

                    <asp:BoundField
                        DataField="DoctorId"
                        HeaderText="ID" />

                    <asp:BoundField
                        DataField="DoctorName"
                        HeaderText="Doctor Name" />

                    <asp:BoundField
                        DataField="Gender"
                        HeaderText="Gender" />

                    <asp:BoundField
                        DataField="Email"
                        HeaderText="Email" />

                    <asp:BoundField
                        DataField="Mobile"
                        HeaderText="Mobile" />

                    <asp:BoundField
                        DataField="Specialization"
                        HeaderText="Specialization" />

                    <asp:TemplateField HeaderText="Action">

                        <ItemTemplate>

                            <asp:LinkButton
                                ID="btnEdit"
                                runat="server"
                                CommandName="EditDoctor"
                                CommandArgument='<%# Eval("DoctorId") %>'
                                CssClass="btn btn-sm btn-primary me-1">
                                Edit
                            </asp:LinkButton>

                            <asp:LinkButton
                                ID="btnDelete"
                                runat="server"
                                CommandName="DeleteDoctor"
                                CommandArgument='<%# Eval("DoctorId") %>'
                                CssClass="btn btn-sm btn-danger"
                                OnClientClick="return confirm('Are you sure you want to delete this doctor?');">
                                Delete
                            </asp:LinkButton>

                        </ItemTemplate>

                    </asp:TemplateField>

                </Columns>

            </asp:GridView>

        </div>

    </div>

</asp:Content>