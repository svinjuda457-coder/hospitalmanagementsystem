using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

using System.Data.SqlClient;
using System.Data;
using System.Configuration;

namespace Hospital_Management_System_01
{
    public partial class WardBeds : System.Web.UI.Page
    {
        SqlConnection con;
        SqlCommand cmd;
        SqlDataAdapter da;
        DataSet ds;

        string s = ConfigurationManager.ConnectionStrings["dbcon"].ConnectionString;

        protected void Page_Load(object sender, EventArgs e)
        {
            getcon();
            if (!IsPostBack)
            {
                bindWard();
                bindBed();
            }
        }

        void getcon()
        {
            con = new SqlConnection(s);
            con.Open();
        }

        void clearWard()
        {
            txtWardName.Text = "";
            txtWardType.Text = "";
            txtWardDescription.Text = "";
        }

        void clearBed()
        {
            txtBedNumber.Text = "";
            txtWardId.Text = "";
            txtBedType.Text = "";
            txtBedStatus.Text = "";
        }

        void bindWard()
        {
            getcon();
            da = new SqlDataAdapter("select * from Wards", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewWards.DataSource = ds;
            GridViewWards.DataBind();
        }

        void bindBed()
        {
            getcon();
            da = new SqlDataAdapter("select * from Beds", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewBeds.DataSource = ds;
            GridViewBeds.DataBind();
        }

        protected void btnAddWard_Click(object sender, EventArgs e)
        {
            getcon();
            cmd = new SqlCommand("insert into Wards(WardName,WardType,Description) values('" + txtWardName.Text + "','" + txtWardType.Text + "','" + txtWardDescription.Text + "')", con);
            cmd.ExecuteNonQuery();
            clearWard();
            bindWard();
            Response.Write("Ward Added Successfully");
        }

        protected void btnAddBed_Click(object sender, EventArgs e)
        {
            getcon();
            cmd = new SqlCommand("insert into Beds(BedNumber,WardId,BedType,Status) values('" + txtBedNumber.Text + "','" + txtWardId.Text + "','" + txtBedType.Text + "','" + txtBedStatus.Text + "')", con);
            cmd.ExecuteNonQuery();
            clearBed();
            bindBed();
            Response.Write("Bed Added Successfully");
        }

        protected void GridViewWards_RowCommand(object sender, GridViewCommandEventArgs e)
        {
            if (e.CommandName == "DeleteWard")
            {
                getcon();
                string id = e.CommandArgument.ToString();
                cmd = new SqlCommand("delete from Wards where WardId='" + id + "'", con);
                cmd.ExecuteNonQuery();
                bindWard();
                Response.Write("Ward Deleted Successfully");
            }
        }

        protected void GridViewBeds_RowCommand(object sender, GridViewCommandEventArgs e)
        {
            if (e.CommandName == "DeleteBed")
            {
                getcon();
                string id = e.CommandArgument.ToString();
                cmd = new SqlCommand("delete from Beds where BedId='" + id + "'", con);
                cmd.ExecuteNonQuery();
                bindBed();
                Response.Write("Bed Deleted Successfully");
            }
        }
    }
}
