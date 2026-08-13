<%@ Page Title="Patients" Language="C#" MasterPageFile="~/AdminMaster.Master"
    AutoEventWireup="true"
    CodeBehind="Patients.aspx.cs"
    Inherits="Hospital_Management_System_01.Patients" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">

    <style>
        .patients-page {
            background: #f4f7fb;
            min-height: calc(100vh - 65px);
        }

        .page-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .page-heading h2 {
            margin: 0;
            color: #2c4964;
            font-weight: 700;
        }

        .page-heading p {
            margin: 5px 0 0;
            color: #7b8794;
        }

        .patient-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        }

        .patient-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .patient-card-header h4 {
            margin: 0;
            color: #2c4964;
            font-weight: 600;
        }

        .patient-count {
            background: #e8f4fc;
            color: #1977cc;
            padding: 7px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .patient-table {
            width: 100%;
        }

        .patient-table th {
            background: #1977cc !important;
            color: white !important;
            padding: 13px 10px !important;
            border: none !important;
        }

        .patient-table td {
            padding: 12px 10px !important;
            vertical-align: middle;
        }

        .patient-table tr:hover {
            background: #f5faff;
        }

        .grid-textbox {
            width: 100%;
            padding: 6px 8px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
    </style>

</asp:Content>


<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">

    <div class="patients-page">

        <div class="page-heading">
            <div>
                <h2>Patients</h2>
                <p>Manage registered hospital patients</p>
            </div>
        </div>

        <div class="patient-card">

            <div class="patient-card-header">
                <h4>
                    <i class="bi bi-people"></i>
                    Registered Patients
                </h4>

                <span class="patient-count">
                    Patient Records
                </span>
            </div>

            <div class="table-responsive">

                <asp:GridView
                    ID="gvPatients"
                    runat="server"
                    AutoGenerateColumns="False"
                    CssClass="table table-bordered table-hover patient-table"
                    Width="100%"
                    EmptyDataText="No patients registered yet."
                    DataKeyNames="PatientId"
                    OnRowEditing="gvPatients_RowEditing"
                    OnRowCancelingEdit="gvPatients_RowCancelingEdit"
                    OnRowUpdating="gvPatients_RowUpdating"
                    OnRowDeleting="gvPatients_RowDeleting">

                    <Columns>

                        <asp:BoundField
                            DataField="PatientId"
                            HeaderText="ID"
                            ReadOnly="True" />

                        <asp:TemplateField HeaderText="Full Name">

                            <ItemTemplate>
                                <%# Eval("FullName") %>
                            </ItemTemplate>

                            <EditItemTemplate>
                                <asp:TextBox
                                    ID="txtGridFullName"
                                    runat="server"
                                    CssClass="grid-textbox"
                                    Text='<%# Bind("FullName") %>'>
                                </asp:TextBox>
                            </EditItemTemplate>

                        </asp:TemplateField>

                        <asp:TemplateField HeaderText="Email">

                            <ItemTemplate>
                                <%# Eval("Email") %>
                            </ItemTemplate>

                            <EditItemTemplate>
                                <asp:TextBox
                                    ID="txtGridEmail"
                                    runat="server"
                                    CssClass="grid-textbox"
                                    Text='<%# Bind("Email") %>'>
                                </asp:TextBox>
                            </EditItemTemplate>

                        </asp:TemplateField>

                        <asp:TemplateField HeaderText="Mobile">

                            <ItemTemplate>
                                <%# Eval("Mobile") %>
                            </ItemTemplate>

                            <EditItemTemplate>
                                <asp:TextBox
                                    ID="txtGridMobile"
                                    runat="server"
                                    CssClass="grid-textbox"
                                    Text='<%# Bind("Mobile") %>'>
                                </asp:TextBox>
                            </EditItemTemplate>

                        </asp:TemplateField>

                        <asp:TemplateField HeaderText="Gender">

                            <ItemTemplate>
                                <%# Eval("Gender") %>
                            </ItemTemplate>

                            <EditItemTemplate>
                                <asp:TextBox
                                    ID="txtGridGender"
                                    runat="server"
                                    CssClass="grid-textbox"
                                    Text='<%# Bind("Gender") %>'>
                                </asp:TextBox>
                            </EditItemTemplate>

                        </asp:TemplateField>

                        <asp:TemplateField HeaderText="Address">

                            <ItemTemplate>
                                <%# Eval("Address") %>
                            </ItemTemplate>

                            <EditItemTemplate>
                                <asp:TextBox
                                    ID="txtGridAddress"
                                    runat="server"
                                    CssClass="grid-textbox"
                                    Text='<%# Bind("Address") %>'>
                                </asp:TextBox>
                            </EditItemTemplate>

                        </asp:TemplateField>

                        <asp:CommandField
                            HeaderText="Actions"
                            ShowEditButton="True"
                            ShowDeleteButton="True"
                            ButtonType="Button"
                            EditText="Edit"
                            DeleteText="Delete"
                            UpdateText="Save"
                            CancelText="Cancel" />

                    </Columns>

                </asp:GridView>

            </div>

        </div>

    </div>

</asp:Content>