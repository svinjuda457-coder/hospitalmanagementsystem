using System;
using System.Configuration;
using System.Data;
using System.Data.SqlClient;

namespace Hospital_Management_System_01
{
    public partial class Appointments : System.Web.UI.Page
    {
        string connectionString =
            ConfigurationManager.ConnectionStrings[
                "HospitalDBConnectionString"
            ].ConnectionString;


        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                LoadAppointments();
            }
        }


        protected void btnAddAppointment_Click(
            object sender,
            EventArgs e)
        {
            if (!Page.IsValid)
            {
                return;
            }


            try
            {
                using (SqlConnection con =
                    new SqlConnection(connectionString))
                {

                    string query = @"
                        INSERT INTO Appointments
                        (
                            Patient,
                            Doctor,
                            AppointmentDate,
                            AppointmentTime,
                            Reason
                        )
                        VALUES
                        (
                            @Patient,
                            @Doctor,
                            @AppointmentDate,
                            @AppointmentTime,
                            @Reason
                        )";


                    using (SqlCommand cmd =
                        new SqlCommand(query, con))
                    {

                        cmd.Parameters.AddWithValue(
                            "@Patient",
                            txtPatient.Text.Trim());

                        cmd.Parameters.AddWithValue(
                            "@Doctor",
                            txtDoctor.Text.Trim());

                        cmd.Parameters.AddWithValue(
                            "@AppointmentDate",
                            DateTime.Parse(
                                txtAppointmentDate.Text));

                        cmd.Parameters.AddWithValue(
                            "@AppointmentTime",
                            txtAppointmentTime.Text.Trim());

                        cmd.Parameters.AddWithValue(
                            "@Reason",
                            txtReason.Text.Trim());


                        con.Open();

                        cmd.ExecuteNonQuery();

                        con.Close();
                    }
                }


                lblMessage.Text =
                    "Appointment added successfully!";

                lblMessage.ForeColor =
                    System.Drawing.Color.Green;


                ClearFields();

                LoadAppointments();
            }
            catch (Exception ex)
            {
                lblMessage.Text =
                    "Error: " + ex.Message;

                lblMessage.ForeColor =
                    System.Drawing.Color.Red;
            }
        }


        private void LoadAppointments()
        {
            try
            {
                using (SqlConnection con =
                    new SqlConnection(connectionString))
                {

                    string query = @"
                        SELECT
                            AppointmentId,
                            Patient,
                            Doctor,
                            AppointmentDate,
                            AppointmentTime,
                            Reason
                        FROM Appointments
                        ORDER BY AppointmentId DESC";


                    using (SqlDataAdapter da =
                        new SqlDataAdapter(query, con))
                    {

                        DataTable dt =
                            new DataTable();

                        da.Fill(dt);

                        gvAppointments.DataSource = dt;

                        gvAppointments.DataBind();
                    }
                }
            }
            catch (Exception ex)
            {
                lblMessage.Text =
                    "Error loading appointments: "
                    + ex.Message;

                lblMessage.ForeColor =
                    System.Drawing.Color.Red;
            }
        }


        private void ClearFields()
        {
            txtPatient.Text = "";
            txtDoctor.Text = "";
            txtAppointmentDate.Text = "";
            txtAppointmentTime.Text = "";
            txtReason.Text = "";
        }
    }
}