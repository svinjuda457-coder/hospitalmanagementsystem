using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

//New Namespace

using System.Data.SqlClient; //For Connection
using System.Data;           //For DataSet
using System.Configuration;  //For connection string

namespace Hospital_Management_System_01
{
    public partial class WardBeds : System.Web.UI.Page
    {
        SqlConnection con; //For connection
        SqlCommand cmd;    //For insert,update,Delete
        SqlDataAdapter da; //For Container
        DataSet ds;        //For Select

        string s = ConfigurationManager.ConnectionStrings["dbcon"].ConnectionString;

        protected void Page_Load(object sender, EventArgs e)
        {
            if (Session["admin"] == null)
            {
                Response.Redirect("~/Login.aspx");
            }
            getcon();
            if (!IsPostBack)
            {
                fillWards();
                fillBeds();
            }
        }

        void getcon()
        {
            con = new SqlConnection(s);
            con.Open();
        }

        void fillWards()
        {
            da = new SqlDataAdapter("Select * from Wards order by WardId desc", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewWards.DataSource = ds;
            GridViewWards.DataBind();
        }

        void fillBeds()
        {
            da = new SqlDataAdapter("Select * from Beds order by BedId desc", con);
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
            txtWardName.Text = "";
            txtWardType.Text = "";
            txtWardDescription.Text = "";
            fillWards();
            Response.Write("Ward Added Successfully");
        }

        protected void btnAddBed_Click(object sender, EventArgs e)
        {
            getcon();
            cmd = new SqlCommand("insert into Beds(BedNumber,WardId,BedType,Status) values('" + txtBedNumber.Text + "','" + txtWardId.Text + "','" + txtBedType.Text + "','" + txtBedStatus.Text + "')", con);
            cmd.ExecuteNonQuery();
            txtBedNumber.Text = "";
            txtWardId.Text = "";
            txtBedType.Text = "";
            txtBedStatus.Text = "";
            fillBeds();
            Response.Write("Bed Added Successfully");
        }

        protected void GridViewWards_RowCommand(object sender, GridViewCommandEventArgs e)
        {
            int id = Convert.ToInt32(e.CommandArgument);

            if (e.CommandName == "DeleteWard")
            {
                getcon();
                cmd = new SqlCommand("Delete from Wards where WardId='" + id + "'", con);
                cmd.ExecuteNonQuery();
                fillWards();
                Response.Write("Ward Deleted Successfully");
            }
        }

        protected void GridViewBeds_RowCommand(object sender, GridViewCommandEventArgs e)
        {
            int id = Convert.ToInt32(e.CommandArgument);

            if (e.CommandName == "DeleteBed")
            {
                getcon();
                cmd = new SqlCommand("Delete from Beds where BedId='" + id + "'", con);
                cmd.ExecuteNonQuery();
                fillBeds();
                Response.Write("Bed Deleted Successfully");
            }
        }
    }
}