<%@ Page Title="Registration"
    Language="C#"
    MasterPageFile="~/Site1.Master"
    AutoEventWireup="true"
    CodeBehind="Registration.aspx.cs"
    Inherits="Hospital_Management_System_01.Registration" %>

<asp:Content ID="Content1"
    ContentPlaceHolderID="ContentPlaceHolder2"
    runat="server">

    <section class="appointment section light-background">

        <div class="container section-title">
            <h2>Patient Registration</h2>
            <p>Register your details with our hospital</p>
        </div>

        <div class="container">

            <div class="row">

                <div class="col-lg-12">

                    <div class="card border-0 shadow-sm p-4 rounded-4">

                        <h3 class="mb-4">Hospital Registration Form</h3>

                        <div class="row gy-4">

                            <div class="col-md-6">
                                <asp:TextBox ID="txtnm"
                                    runat="server"
                                    CssClass="form-control"
                                    placeholder="Full Name" />
                            </div>

                            <div class="col-md-6">
                                <asp:TextBox ID="txtMobile"
                                    runat="server"
                                    CssClass="form-control"
                                    placeholder="Mobile Number" />
                            </div>

                            <div class="col-md-12">
                                <asp:TextBox ID="txtAddress"
                                    runat="server"
                                    TextMode="MultiLine"
                                    Rows="4"
                                    CssClass="form-control"
                                    placeholder="Address" />
                            </div>

                            <div class="col-md-6">

                                <label class="form-label">Gender</label>

                                <asp:RadioButtonList
                                    ID="rbdgndr"
                                    runat="server"
                                    RepeatDirection="Horizontal">

                                    <asp:ListItem Text="Male" Value="Male" />
                                    <asp:ListItem Text="Female" Value="Female" />

                                </asp:RadioButtonList>

                            </div>

                            <div class="col-md-6">
                                <asp:TextBox ID="txteml"
                                    runat="server"
                                    CssClass="form-control"
                                    placeholder="Email Address" />
                            </div>

                            <div class="col-md-6">
                                <asp:TextBox ID="txtct"
                                    runat="server"
                                    CssClass="form-control"
                                    placeholder="City" />
                            </div>

                            <div class="col-md-12 text-center">

                                <asp:Button
                                    ID="btnRegister"
                                    runat="server"
                                    Text="Register"
                                    CssClass="btn btn-primary px-5 py-2 rounded-pill"
                                    OnClick="btnRegister_Click" />

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- Registered Patients -->

    <section class="section">

        <div class="container">

            <div class="section-title">
                <h2>Registered Patients</h2>
                <p>Patient registration records</p>
            </div>

            <div class="table-responsive">

                <asp:GridView
                    ID="GridView1"
                    runat="server"
                    AutoGenerateColumns="False"
                    CssClass="table table-bordered table-striped table-hover"
                    OnRowCommand="Gridview1_RowCommand">

                    <Columns>

                        <asp:BoundField
                            DataField="Id"
                            HeaderText="ID" />

                        <asp:BoundField
                            DataField="Name"
                            HeaderText="Name" />

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

                                <asp:Button
                                    ID="btnEdit"
                                    runat="server"
                                    Text="Edit"
                                    CssClass="btn btn-warning btn-sm me-2"
                                    CommandName="cmd_edit"
                                    CommandArgument='<%# Eval("Id") %>' />

                                <asp:Button
                                    ID="btnDelete"
                                    runat="server"
                                    Text="Delete"
                                    CssClass="btn btn-danger btn-sm"
                                    CommandName="cmd_delete"
                                    CommandArgument='<%# Eval("Id") %>'
                                    OnClientClick="return confirm('Are you sure you want to delete this patient?');" />

                            </ItemTemplate>

                        </asp:TemplateField>

                    </Columns>

                </asp:GridView>

            </div>

        </div>

    </section>

</asp:Content>

<%--<%@ Page Title="Registration" 
    Language="C#" 
    MasterPageFile="~/Site1.Master" 
    AutoEventWireup="true" 
    CodeBehind="Registration.aspx.cs" 
    Inherits="Hospital_Management_System_01.Registration" %> 
 
<asp:Content ID="Content1" 
    ContentPlaceHolderID="ContentPlaceHolder1" 
    runat="server"> 
 
    <section class="appointment section light-background"> 
 
        <div class="container section-title"> 
            <h2>Patient Registration</h2> 
            <p>Register your details with our hospital</p> 
        </div> 
 
        <div class="container"> 
 
            <div class="row"> 
 
                <div class="col-lg-12"> 
 
                    <div class="card border-0 shadow-sm p-4 rounded-4"> 
 
                        <h3 class="mb-4">Hospital Registration Form</h3> 
 
                        <div class="row gy-4"> 
 
                            <!-- Full Name -->
                            <div class="col-md-6"> 
                                <asp:TextBox ID="txtnm" 
                                    runat="server" 
                                    CssClass="form-control" 
                                    placeholder="Full Name" /> 
                            </div> 
 
                            <!-- Mobile -->
                            <div class="col-md-6"> 
                                <asp:TextBox ID="txtMobile" 
                                    runat="server" 
                                    CssClass="form-control" 
                                    placeholder="Mobile Number" /> 
                            </div> 
 
                            <!-- Address -->
                            <div class="col-md-12"> 
                                <asp:TextBox ID="txtAddress" 
                                    runat="server" 
                                    TextMode="MultiLine" 
                                    Rows="4" 
                                    CssClass="form-control" 
                                    placeholder="Address" /> 
                            </div> 
 
                            <!-- Gender -->
                            <div class="col-md-6"> 
 
                                <label class="form-label">Gender</label> 
 
                                <asp:RadioButtonList 
                                    ID="rbdgndr" 
                                    runat="server" 
                                    RepeatDirection="Horizontal"> 
 
                                    <asp:ListItem Text="Male" Value="Male" /> 
                                    <asp:ListItem Text="Female" Value="Female" /> 
 
                                </asp:RadioButtonList> 
 
                            </div> 
 
                            <!-- Email -->
                            <div class="col-md-6"> 
                                <asp:TextBox ID="txteml" 
                                    runat="server" 
                                    CssClass="form-control" 
                                    TextMode="Email"
                                    placeholder="Email Address" /> 
                            </div> 
 
                            <!-- City Dropdown -->
                            <div class="col-md-6"> 
 
                                <asp:DropDownList 
                                    ID="drpcity" 
                                    runat="server" 
                                    CssClass="form-select"> 
 
                                    <asp:ListItem Value="">
                                        -- Select City --
                                    </asp:ListItem>

                                    <asp:ListItem Value="Mumbai">
                                        Mumbai
                                    </asp:ListItem>

                                    <asp:ListItem Value="Delhi">
                                        Delhi
                                    </asp:ListItem>

                                    <asp:ListItem Value="Bangalore">
                                        Bangalore
                                    </asp:ListItem>

                                    <asp:ListItem Value="Ahmedabad">
                                        Ahmedabad
                                    </asp:ListItem>

                                    <asp:ListItem Value="Surat">
                                        Surat
                                    </asp:ListItem>

                                    <asp:ListItem Value="Vadodara">
                                        Vadodara
                                    </asp:ListItem>

                                    <asp:ListItem Value="Rajkot">
                                        Rajkot
                                    </asp:ListItem>

                                </asp:DropDownList>
 
                            </div> 
 
                            <!-- Register Button -->
                            <div class="col-md-12 text-center"> 
 
                                <asp:Button 
                                    ID="btnRegister" 
                                    runat="server" 
                                    Text="Register" 
                                    CssClass="btn btn-primary px-5 py-2 rounded-pill" 
                                    OnClick="btnRegister_Click" /> 
 
                            </div> 
 
                        </div> 
 
                    </div> 
 
                </div> 
 
            </div> 
 
        </div> 
 
    </section> 
 
 
    <!-- Registered Patients --> 
 
    <section class="section"> 
 
        <div class="container"> 
 
            <div class="section-title"> 
                <h2>Registered Patients</h2> 
                <p>Patient registration records</p> 
            </div> 
 
            <div class="table-responsive"> 
 
                <asp:GridView 
                    ID="GridView1" 
                    runat="server" 
                    AutoGenerateColumns="False" 
                    CssClass="table table-bordered table-striped table-hover" 
                    OnRowCommand="Gridview1_RowCommand"> 
 
                    <Columns> 
 
                        <asp:BoundField 
                            DataField="Id" 
                            HeaderText="ID" /> 
 
                        <asp:BoundField 
                            DataField="Name" 
                            HeaderText="Name" /> 
 
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
 
                                <asp:Button 
                                    ID="btnEdit" 
                                    runat="server" 
                                    Text="Edit" 
                                    CssClass="btn btn-warning btn-sm me-2" 
                                    CommandName="cmd_edit" 
                                    CommandArgument='<%# Eval("Id") %>' /> 
 
                                <asp:Button 
                                    ID="btnDelete" 
                                    runat="server" 
                                    Text="Delete" 
                                    CssClass="btn btn-danger btn-sm" 
                                    CommandName="cmd_delete" 
                                    CommandArgument='<%# Eval("Id") %>' 
                                    OnClientClick="return confirm('Are you sure you want to delete this patient?');" /> 
 
                            </ItemTemplate> 
 
                        </asp:TemplateField> 
 
                    </Columns> 
 
                </asp:GridView> 
 
            </div> 
 
        </div> 
 
    </section> 
 
</asp:Content>--%>