using System;
using System.Configuration;
using System.Data;
using System.Data.SqlClient;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace Hospital_Management_System_01
{
    public partial class Patients : System.Web.UI.Page
    {
        string cs = ConfigurationManager
            .ConnectionStrings["HospitalDBConnectionString"]
            .ConnectionString;

        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                LoadPatients();
            }
        }

        private void LoadPatients()
        {
            using (SqlConnection con = new SqlConnection(cs))
            {
                string query = @"
                    SELECT
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
                    DataTable dt = new DataTable();

                    da.Fill(dt);

                    gvPatients.DataSource = dt;
                    gvPatients.DataBind();
                }
            }
        }

        protected void gvPatients_RowEditing(
            object sender,
            GridViewEditEventArgs e)
        {
            gvPatients.EditIndex = e.NewEditIndex;

            LoadPatients();
        }

        protected void gvPatients_RowCancelingEdit(
            object sender,
            GridViewCancelEditEventArgs e)
        {
            gvPatients.EditIndex = -1;

            LoadPatients();
        }

        protected void gvPatients_RowUpdating(
            object sender,
            GridViewUpdateEventArgs e)
        {
            try
            {
                int patientId = Convert.ToInt32(
                    gvPatients.DataKeys[e.RowIndex].Value
                );

                GridViewRow row = gvPatients.Rows[e.RowIndex];

                TextBox txtName =
                    (TextBox)row.FindControl("txtGridFullName");

                TextBox txtEmail =
                    (TextBox)row.FindControl("txtGridEmail");

                TextBox txtMobile =
                    (TextBox)row.FindControl("txtGridMobile");

                TextBox txtGender =
                    (TextBox)row.FindControl("txtGridGender");

                TextBox txtAddress =
                    (TextBox)row.FindControl("txtGridAddress");

                using (SqlConnection con =
                       new SqlConnection(cs))
                {
                    string query = @"
                        UPDATE Patients
                        SET
                            FullName = @FullName,
                            Email = @Email,
                            Mobile = @Mobile,
                            Gender = @Gender,
                            Address = @Address
                        WHERE PatientId = @PatientId";

                    using (SqlCommand cmd =
                           new SqlCommand(query, con))
                    {
                        cmd.Parameters.AddWithValue(
                            "@FullName",
                            txtName.Text.Trim()
                        );

                        cmd.Parameters.AddWithValue(
                            "@Email",
                            txtEmail.Text.Trim()
                        );

                        cmd.Parameters.AddWithValue(
                            "@Mobile",
                            txtMobile.Text.Trim()
                        );

                        cmd.Parameters.AddWithValue(
                            "@Gender",
                            txtGender.Text.Trim()
                        );

                        cmd.Parameters.AddWithValue(
                            "@Address",
                            txtAddress.Text.Trim()
                        );

                        cmd.Parameters.AddWithValue(
                            "@PatientId",
                            patientId
                        );

                        con.Open();

                        cmd.ExecuteNonQuery();

                        con.Close();
                    }
                }

                gvPatients.EditIndex = -1;

                LoadPatients();

                Response.Write(
                    "<script>alert('Patient Updated Successfully!');</script>"
                );
            }
            catch (Exception ex)
            {
                Response.Write(
                    "<script>alert('Update Error: " +
                    ex.Message.Replace("'", "") +
                    "');</script>"
                );
            }
        }

        protected void gvPatients_RowDeleting(
            object sender,
            GridViewDeleteEventArgs e)
        {
            try
            {
                int patientId = Convert.ToInt32(
                    gvPatients.DataKeys[e.RowIndex].Value
                );

                using (SqlConnection con =
                       new SqlConnection(cs))
                {
                    string query = @"
                        DELETE FROM Patients
                        WHERE PatientId = @PatientId";

                    using (SqlCommand cmd =
                           new SqlCommand(query, con))
                    {
                        cmd.Parameters.AddWithValue(
                            "@PatientId",
                            patientId
                        );

                        con.Open();

                        cmd.ExecuteNonQuery();

                        con.Close();
                    }
                }

                LoadPatients();

                Response.Write(
                    "<script>alert('Patient Deleted Successfully!');</script>"
                );
            }
            catch (Exception ex)
            {
                Response.Write(
                    "<script>alert('Delete Error: " +
                    ex.Message.Replace("'", "") +
                    "');</script>"
                );
            }
        }
    }
}