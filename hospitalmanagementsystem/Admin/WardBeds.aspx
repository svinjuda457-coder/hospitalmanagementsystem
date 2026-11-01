<%@ Page Title="Ward & Beds" Language="C#"
    MasterPageFile="~/Admin/AdminMaster.Master"
    AutoEventWireup="true"
    CodeBehind="WardBeds.aspx.cs"
    Inherits="Hospital_Management_System_01.WardBeds" %>

<asp:Content ID="Content1"
    ContentPlaceHolderID="head"
    runat="server">
</asp:Content>


<asp:Content ID="Content2"
    ContentPlaceHolderID="ContentPlaceHolder1"
    runat="server">

    <div>

        <div class="page-title">
            Ward & Beds
        </div>

        <div class="welcome">
            Manage hospital wards and beds
        </div>


        <!-- ADD WARD -->

        <div class="dashboard-box">

            <div class="box-title">
                Add Ward
            </div>

            <div class="row">

                <div class="col-md-4">

                    <label>Ward Name</label>

                    <asp:TextBox
                        ID="txtWardName"
                        runat="server"
                        CssClass="form-control"
                        placeholder="Enter ward name">
                    </asp:TextBox>

                </div>


                <div class="col-md-4">

                    <label>Ward Type</label>

                    <asp:TextBox
                        ID="txtWardType"
                        runat="server"
                        CssClass="form-control"
                        placeholder="Enter ward type">
                    </asp:TextBox>

                </div>


                <div class="col-md-4">

                    <label>Description</label>

                    <asp:TextBox
                        ID="txtWardDescription"
                        runat="server"
                        CssClass="form-control"
                        placeholder="Enter description">
                    </asp:TextBox>

                </div>

            </div>

            <br />

            <asp:Button
                ID="btnAddWard"
                runat="server"
                Text="Add Ward"
                CssClass="btn btn-primary"
                OnClick="btnAddWard_Click" />

        </div>


        <!-- WARD LIST -->

        <div class="dashboard-box">

            <div class="box-title">
                Ward List
            </div>

            <asp:GridView
                ID="GridViewWards"
                runat="server"
                AutoGenerateColumns="False"
                CssClass="table table-bordered table-hover"
                OnRowCommand="GridViewWards_RowCommand">

                <Columns>

                    <asp:BoundField
                        DataField="WardId"
                        HeaderText="ID" />

                    <asp:BoundField
                        DataField="WardName"
                        HeaderText="Ward Name" />

                    <asp:BoundField
                        DataField="WardType"
                        HeaderText="Ward Type" />

                    <asp:BoundField
                        DataField="Description"
                        HeaderText="Description" />

                    <asp:TemplateField HeaderText="Action">

                        <ItemTemplate>

                            <asp:Button
                                ID="btnDeleteWard"
                                runat="server"
                                Text="Delete"
                                CssClass="btn btn-danger btn-sm"
                                CommandName="DeleteWard"
                                CommandArgument='<%# Eval("WardId") %>' />

                        </ItemTemplate>

                    </asp:TemplateField>

                </Columns>

            </asp:GridView>

        </div>


        <!-- ADD BED -->

        <div class="dashboard-box">

            <div class="box-title">
                Add Bed
            </div>

            <div class="row">

                <div class="col-md-3">

                    <label>Bed Number</label>

                    <asp:TextBox
                        ID="txtBedNumber"
                        runat="server"
                        CssClass="form-control"
                        placeholder="Enter bed number">
                    </asp:TextBox>

                </div>


                <div class="col-md-3">

                    <label>Ward ID</label>

                    <asp:TextBox
                        ID="txtWardId"
                        runat="server"
                        CssClass="form-control"
                        placeholder="Enter ward ID">
                    </asp:TextBox>

                </div>


                <div class="col-md-3">

                    <label>Bed Type</label>

                    <asp:TextBox
                        ID="txtBedType"
                        runat="server"
                        CssClass="form-control"
                        placeholder="Enter bed type">
                    </asp:TextBox>

                </div>


                <div class="col-md-3">

                    <label>Status</label>

                    <asp:TextBox
                        ID="txtBedStatus"
                        runat="server"
                        CssClass="form-control"
                        placeholder="Available / Occupied">
                    </asp:TextBox>

                </div>

            </div>

            <br />

            <asp:Button
                ID="btnAddBed"
                runat="server"
                Text="Add Bed"
                CssClass="btn btn-primary"
                OnClick="btnAddBed_Click" />

        </div>


        <!-- BED LIST -->

        <div class="dashboard-box">

            <div class="box-title">
                Bed List
            </div>

            <asp:GridView
                ID="GridViewBeds"
                runat="server"
                AutoGenerateColumns="False"
                CssClass="table table-bordered table-hover"
                OnRowCommand="GridViewBeds_RowCommand">

                <Columns>

                    <asp:BoundField
                        DataField="BedId"
                        HeaderText="ID" />

                    <asp:BoundField
                        DataField="BedNumber"
                        HeaderText="Bed Number" />

                    <asp:BoundField
                        DataField="WardId"
                        HeaderText="Ward ID" />

                    <asp:BoundField
                        DataField="BedType"
                        HeaderText="Bed Type" />

                    <asp:BoundField
                        DataField="Status"
                        HeaderText="Status" />

                    <asp:TemplateField HeaderText="Action">

                        <ItemTemplate>

                            <asp:Button
                                ID="btnDeleteBed"
                                runat="server"
                                Text="Delete"
                                CssClass="btn btn-danger btn-sm"
                                CommandName="DeleteBed"
                                CommandArgument='<%# Eval("BedId") %>' />

                        </ItemTemplate>

                    </asp:TemplateField>

                </Columns>

            </asp:GridView>

        </div>

    </div>

</asp:Content>