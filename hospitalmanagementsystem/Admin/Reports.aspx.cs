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
    public partial class Reports : System.Web.UI.Page
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
                totalPatients();
                totalDepartments();
                totalServices();
                fillReport();
            }
        }

        void getcon()
        {
            con = new SqlConnection(s);
            con.Open();
        }

        void totalPatients()
        {
            cmd = new SqlCommand("Select count(*) from Registration", con);
            lblPatients.Text = cmd.ExecuteScalar().ToString();
        }

        void totalDepartments()
        {
            cmd = new SqlCommand("Select count(*) from Departments", con);
            lblDepartments.Text = cmd.ExecuteScalar().ToString();
        }

        void totalServices()
        {
            cmd = new SqlCommand("Select count(*) from Services", con);
            lblServices.Text = cmd.ExecuteScalar().ToString();
        }

        void fillReport()
        {
            da = new SqlDataAdapter("Select * from Registration order by Id desc", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewReport.DataSource = ds;
            GridViewReport.DataBind();
        }
    }
}