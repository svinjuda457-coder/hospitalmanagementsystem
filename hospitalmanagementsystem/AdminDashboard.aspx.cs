using System;
using System.Configuration;
using System.Data;
using System.Data.SqlClient;

namespace Hospital_Management_System_01
{
    public partial class AdminDashboard : System.Web.UI.Page
    {
        private string cs = ConfigurationManager
            .ConnectionStrings["HospitalDBConnectionString"]
            .ConnectionString;


        protected void Page_Load(object sender, EventArgs e)
        {
            if (Session["AdminEmail"] == null)
            {
                Response.Redirect("AdminLogin.aspx");
                return;
            }

            if (!IsPostBack)
            {
                LoadDashboard();
                LoadRecentPatients();
            }
        }


        // =========================================
        // LOAD DASHBOARD
        // =========================================

        private void LoadDashboard()
        {
            // Actual registered patients count
            lblPatients.Text = GetCount("Patients");

            // Tables not created yet
            lblAppointments.Text = "0";
            lblDoctors.Text = "0";
            lblDepartments.Text = "0";
        }


        // =========================================
        // GET TABLE COUNT
        // =========================================

        private string GetCount(string tableName)
        {
            using (SqlConnection con =
                   new SqlConnection(cs))
            {
                string query =
                    "SELECT COUNT(*) FROM " + tableName;

                using (SqlCommand cmd =
                       new SqlCommand(query, con))
                {
                    con.Open();

                    object result =
                        cmd.ExecuteScalar();

                    return Convert.ToString(result);
                }
            }
        }


        // =========================================
        // RECENT REGISTERED PATIENTS
        // =========================================

        private void LoadRecentPatients()
        {
            using (SqlConnection con =
                   new SqlConnection(cs))
            {
                string query = @"
                    SELECT TOP 5
                        PatientId,
                        FullName,
                        Email,
                        Mobile,
                        Gender,
                        Address
                    FROM Patients
                    ORDER BY PatientId DESC";


                using (SqlDataAdapter da =
                       new SqlDataAdapter(query, con))
                {
                    DataTable dt =
                        new DataTable();

                    da.Fill(dt);

                    gvPatients.DataSource = dt;

                    gvPatients.DataBind();
                }
            }
        }


        // =========================================
        // LOGOUT
        // =========================================

        protected void btnLogout_Click(
            object sender,
            EventArgs e)
        {
            Session.Clear();

            Session.Abandon();

            Response.Redirect("AdminLogin.aspx");
        }
    }
}