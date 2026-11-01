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
    public partial class PatientProfile : System.Web.UI.Page
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
                DisplayProfile();
            }
        }

        void getcon()
        {
            con = new SqlConnection(s);
            con.Open();
        }

        void DisplayProfile()
        {
            da = new SqlDataAdapter("Select * from Users where Email = '" + Session["patient"].ToString() + "' and Role = 'Patient'", con);
            ds = new DataSet();
            da.Fill(ds);

            if (ds.Tables[0].Rows.Count > 0)
            {
                txtPatientName.Text = ds.Tables[0].Rows[0]["Name"].ToString();
                txtEmail.Text = ds.Tables[0].Rows[0]["Email"].ToString();
            }
        }

        protected void btnUpdate_Click(object sender, EventArgs e)
        {
            getcon();
            cmd = new SqlCommand("Update Users set Name = '" + txtPatientName.Text + "' where Email = '" + txtEmail.Text + "' and Role = 'Patient'", con);
            cmd.ExecuteNonQuery();
            Response.Write("Profile Updated Successfully");
        }
    }
}