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

namespace Hospital_Management_System_01.Doctor
{
    public partial class DoctorDashboard : System.Web.UI.Page
    {
        SqlConnection con; //For connection
        SqlCommand cmd;    //For insert,update,Delete
        SqlDataAdapter da; //For Container
        DataSet ds;        //For Select

        string s = ConfigurationManager.ConnectionStrings["dbcon"].ConnectionString;

        protected void Page_Load(object sender, EventArgs e)
        {
            if (Session["doctor"] == null)
            {
                Response.Redirect("~/Login.aspx");
            }
            if (!IsPostBack)
            {
                fillname();
                totalPatients();
                totalAppointments();
                totalPrescriptions();
                fillAppointments();
            }
        }

        void getcon()
        {
            con = new SqlConnection(s);
            con.Open();
        }

        void fillname()
        {
            getcon();
            da = new SqlDataAdapter("Select Name from Users where Email = '" + Session["doctor"].ToString() + "'", con);
            ds = new DataSet();
            da.Fill(ds);
            if (ds.Tables[0].Rows.Count > 0)
            {
                lblDoctorName.Text = ds.Tables[0].Rows[0]["Name"].ToString();
            }
            else
            {
                lblDoctorName.Text = Session["doctor"].ToString();
            }
            con.Close();
        }

        void totalPatients()
        {
            getcon();
            cmd = new SqlCommand("Select count(*) from Users where Role = 'Patient'", con);
            lblPatients.Text = cmd.ExecuteScalar().ToString();
            con.Close();
        }

        void totalAppointments()
        {
            getcon();
            cmd = new SqlCommand("Select count(*) from Appointments", con);
            lblAppointments.Text = cmd.ExecuteScalar().ToString();
            con.Close();
        }

        void totalPrescriptions()
        {
            getcon();
            cmd = new SqlCommand("Select count(*) from Prescriptions", con);
            lblPrescriptions.Text = cmd.ExecuteScalar().ToString();
            con.Close();
        }

        void fillAppointments()
        {
            getcon();
            da = new SqlDataAdapter("Select top 5 * from Appointments order by AppointmentId desc", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewAppointments.DataSource = ds;
            GridViewAppointments.DataBind();
            con.Close();
        }
    }
}