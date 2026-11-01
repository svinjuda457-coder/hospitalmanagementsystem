using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

using System.Data.SqlClient;
using System.Data;
using System.Configuration;

namespace Hospital_Management_System_01.Patient
{
    public partial class PatientDashboard : System.Web.UI.Page
    {
        SqlConnection con;
        SqlCommand cmd;
        SqlDataAdapter da;
        DataSet ds;

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
                try
                {
                    cmd = new SqlCommand("SELECT PatientName FROM Patients WHERE Email = '" + Session["patient"].ToString() + "'", con);
                    object objName = cmd.ExecuteScalar();
                    if (objName != null)
                    {
                        Session["patient"] = objName.ToString();
                    }
                }
                catch
                {
                }

                lblPatientName.Text = Session["patient"].ToString();
                totalAppointments();
                upcomingAppointments();
                completedAppointments();
                totalPrescriptions();
                DisplayAppointments();
            }
        }

        void getcon()
        {
            con = new SqlConnection(s);
            con.Open();
        }

        void totalAppointments()
        {
            cmd = new SqlCommand("SELECT COUNT(*) FROM Appointments WHERE PatientName = '" + Session["patient"].ToString() + "'", con);
            int total = Convert.ToInt32(cmd.ExecuteScalar());
            lblTotalAppt.Text = total.ToString();
        }

        void upcomingAppointments()
        {
            cmd = new SqlCommand("SELECT COUNT(*) FROM Appointments WHERE PatientName = '" + Session["patient"].ToString() + "' AND AppointmentDate >= CONVERT(date, GETDATE())", con);
            int total = Convert.ToInt32(cmd.ExecuteScalar());
            lblUpcoming.Text = total.ToString();
        }

        void completedAppointments()
        {
            cmd = new SqlCommand("SELECT COUNT(*) FROM Appointments WHERE PatientName = '" + Session["patient"].ToString() + "' AND Status = 'Completed'", con);
            int total = Convert.ToInt32(cmd.ExecuteScalar());
            lblCompleted.Text = total.ToString();
        }

        void totalPrescriptions()
        {
            try
            {
                cmd = new SqlCommand("SELECT COUNT(*) FROM Prescriptions WHERE PatientName = '" + Session["patient"].ToString() + "'", con);
                int total = Convert.ToInt32(cmd.ExecuteScalar());
                lblPrescriptions.Text = total.ToString();
            }
            catch
            {
                lblPrescriptions.Text = "0";
            }
        }

        void DisplayAppointments()
        {
            da = new SqlDataAdapter("Select AppointmentId as Id, DoctorName, AppointmentDate, AppointmentTime, Status from Appointments where PatientName = '" + Session["patient"].ToString() + "'", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewAppointments.DataSource = ds;
            GridViewAppointments.DataBind();
        }

    }
}
