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
    public partial class BookAppointment : System.Web.UI.Page
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
                txtPatientName.Text = Session["patient"].ToString();
            }
        }

        void getcon()
        {
            con = new SqlConnection(s);
            con.Open();
        }

        void clear()
        {
            txtDoctorName.Text = "";
            txtDate.Text = "";
            txtTime.Text = "";
            txtReason.Text = "";
        }

        protected void btnBook_Click(object sender, EventArgs e)
        {
            getcon();
            cmd = new SqlCommand("insert into Appointments(PatientName,DoctorName,AppointmentDate,AppointmentTime,Status) values('" + txtPatientName.Text + "','" + txtDoctorName.Text + "','" + txtDate.Text + "','" + txtTime.Text + "','Pending')", con);
            cmd.ExecuteNonQuery();
            clear();
            Response.Write("Appointment Booked Successfully");
        }

    }
}