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

namespace Hospital_Management_System_01.Patient
{
    public partial class MyPrescriptions : System.Web.UI.Page
    {
        SqlConnection con; //For connection
        SqlCommand cmd;    //For insert,update,Delete
        SqlDataAdapter da; //For Container
        DataSet ds;        //For Select

        string s = ConfigurationManager.ConnectionStrings["dbcon"].ConnectionString;

        protected void Page_Load(object sender, EventArgs e)
        {
            if (Session["patient"] == null)
            {
                Response.Redirect("~/Login.aspx");
            }
            getcon();
            if (!IsPostBack)
            {
                DisplayPrescriptions();
            }
        }

        void getcon()
        {
            con = new SqlConnection(s);
            con.Open();
        }

        void DisplayPrescriptions()
        {
            da = new SqlDataAdapter("Select * from Prescriptions where PatientName = '" + Session["patient"].ToString() + "'", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewPrescriptions.DataSource = ds;
            GridViewPrescriptions.DataBind();
        }
    }
}