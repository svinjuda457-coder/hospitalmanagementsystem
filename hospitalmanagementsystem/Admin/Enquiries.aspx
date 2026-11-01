<%@ Page Title="Enquiries"
    Language="C#"
    MasterPageFile="~/Admin/AdminMaster.Master"
    AutoEventWireup="true"
    CodeBehind="Enquiries.aspx.cs"
    Inherits="Hospital_Management_System_01.Enquiries" %>

<asp:Content ID="Content1"
    ContentPlaceHolderID="head"
    runat="server">
</asp:Content>

<asp:Content ID="Content2"
    ContentPlaceHolderID="ContentPlaceHolder1"
    runat="server">

    <div class="page-title">
        Enquiries
    </div>

    <div class="welcome">
        Manage Patient Enquiries
    </div>

    <div class="dashboard-box">

        <div class="box-title">
            Add Enquiry
        </div>

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>Name</label>

                <asp:TextBox ID="txtName"
                    runat="server"
                    CssClass="form-control"
                    placeholder="Enter name">
                </asp:TextBox>
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
                <label>Subject</label>

                <asp:TextBox ID="txtSubject"
                    runat="server"
                    CssClass="form-control"
                    placeholder="Enter subject">
                </asp:TextBox>
            </div>

            <div class="col-md-12 mb-3">
                <label>Message</label>

                <asp:TextBox ID="txtMessage"
                    runat="server"
                    CssClass="form-control"
                    TextMode="MultiLine"
                    Rows="4"
                    placeholder="Enter message">
                </asp:TextBox>
            </div>

        </div>

        <asp:Button ID="btnAddEnquiry"
            runat="server"
            Text="Add Enquiry"
            CssClass="btn btn-primary"
            OnClick="btnAddEnquiry_Click" />

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
            Enquiry List
        </div>

        <div class="table-responsive">

            <asp:GridView ID="GridViewEnquiries"
                runat="server"
                AutoGenerateColumns="False"
                CssClass="table table-hover"
                EmptyDataText="No enquiries found."
                OnRowCommand="GridViewEnquiries_RowCommand">

                <Columns>

                    <asp:BoundField
                        DataField="EnquiryId"
                        HeaderText="ID" />

                    <asp:BoundField
                        DataField="Name"
                        HeaderText="Name" />

                    <asp:BoundField
                        DataField="Email"
                        HeaderText="Email" />

                    <asp:BoundField
                        DataField="Mobile"
                        HeaderText="Mobile" />

                    <asp:BoundField
                        DataField="Subject"
                        HeaderText="Subject" />

                    <asp:BoundField
                        DataField="Message"
                        HeaderText="Message" />

                    <asp:TemplateField HeaderText="Action">

                        <ItemTemplate>

                            <asp:LinkButton
                                ID="btnDelete"
                                runat="server"
                                CommandName="DeleteEnquiry"
                                CommandArgument='<%# Eval("EnquiryId") %>'
                                CssClass="btn btn-sm btn-danger"
                                OnClientClick="return confirm('Are you sure you want to delete this enquiry?');">
                                Delete
                            </asp:LinkButton>

                        </ItemTemplate>

                    </asp:TemplateField>

                </Columns>

            </asp:GridView>

        </div>

    </div>

</asp:Content>