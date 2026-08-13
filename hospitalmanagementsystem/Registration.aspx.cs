using System;
using System.Configuration;
using System.Data;
using System.Data.SqlClient;
using System.Web.UI.WebControls;

namespace Hospital_Management_System_01
{
    public partial class Registration : System.Web.UI.Page
    {
        string cs = ConfigurationManager
            .ConnectionStrings["HospitalDBConnectionString"]
            .ConnectionString;


        // =========================================
        // PAGE LOAD
        // =========================================

        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                LoadPatients();
            }
        }


        // =========================================
        // LOAD PATIENTS
        // =========================================

        private void LoadPatients()
        {
            using (SqlConnection con = new SqlConnection(cs))
            {
                string query = @"SELECT
                                    PatientId,
                                    FullName,
                                    Email,
                                    Mobile,
                                    Gender,
                                    Address
                                 FROM Patients
                                 ORDER BY PatientId DESC";

                SqlDataAdapter da =
                    new SqlDataAdapter(query, con);

                DataTable dt = new DataTable();

                da.Fill(dt);

                gvPatients.DataSource = dt;

                gvPatients.DataBind();
            }
        }


        // =========================================
        // REGISTER PATIENT
        // =========================================

        protected void btnRegister_Click(object sender, EventArgs e)
        {
            string gender = "";


            // Get Gender

            if (rbMale.Checked)
            {
                gender = "Male";
            }
            else if (rbFemale.Checked)
            {
                gender = "Female";
            }
            else if (rbOther.Checked)
            {
                gender = "Other";
            }


            // Password Check

            if (txtPassword.Text != txtConfirmPassword.Text)
            {
                Response.Write(
                    "<script>alert('Password and Confirm Password do not match');</script>"
                );

                return;
            }


            // Insert Patient

            using (SqlConnection con =
                   new SqlConnection(cs))
            {
                string query = @"INSERT INTO Patients
                                (
                                    FullName,
                                    Email,
                                    Mobile,
                                    Gender,
                                    Address,
                                    Password
                                )
                                VALUES
                                (
                                    @FullName,
                                    @Email,
                                    @Mobile,
                                    @Gender,
                                    @Address,
                                    @Password
                                )";


                SqlCommand cmd =
                    new SqlCommand(query, con);


                cmd.Parameters.AddWithValue(
                    "@FullName",
                    txtFullName.Text
                );

                cmd.Parameters.AddWithValue(
                    "@Email",
                    txtEmail.Text
                );

                cmd.Parameters.AddWithValue(
                    "@Mobile",
                    txtMobile.Text
                );

                cmd.Parameters.AddWithValue(
                    "@Gender",
                    gender
                );

                cmd.Parameters.AddWithValue(
                    "@Address",
                    txtAddress.Text
                );

                cmd.Parameters.AddWithValue(
                    "@Password",
                    txtPassword.Text
                );


                con.Open();

                cmd.ExecuteNonQuery();

                con.Close();
            }


            // Refresh GridView

            LoadPatients();


            // Success Message

            Response.Write(
                "<script>alert('Patient Registration Successful');</script>"
            );


            // Clear Form

            txtFullName.Text = "";
            txtEmail.Text = "";
            txtMobile.Text = "";
            txtAddress.Text = "";
            txtPassword.Text = "";
            txtConfirmPassword.Text = "";

            rbMale.Checked = false;
            rbFemale.Checked = false;
            rbOther.Checked = false;
        }


        // =========================================
        // EDIT
        // =========================================

        protected void gvPatients_RowEditing(
            object sender,
            GridViewEditEventArgs e)
        {
            gvPatients.EditIndex = e.NewEditIndex;

            LoadPatients();
        }


        // =========================================
        // CANCEL EDIT
        // =========================================

        protected void gvPatients_RowCancelingEdit(
            object sender,
            GridViewCancelEditEventArgs e)
        {
            gvPatients.EditIndex = -1;

            LoadPatients();
        }


        // =========================================
        // UPDATE
        // =========================================

        protected void gvPatients_RowUpdating(
            object sender,
            GridViewUpdateEventArgs e)
        {
            int patientId =
                Convert.ToInt32(
                    gvPatients.DataKeys[e.RowIndex].Value
                );


            GridViewRow row =
                gvPatients.Rows[e.RowIndex];


            // Find TextBoxes

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


            // Update Database

            using (SqlConnection con =
                   new SqlConnection(cs))
            {
                string query = @"UPDATE Patients
                                 SET
                                    FullName = @FullName,
                                    Email = @Email,
                                    Mobile = @Mobile,
                                    Gender = @Gender,
                                    Address = @Address
                                 WHERE PatientId = @PatientId";


                SqlCommand cmd =
                    new SqlCommand(query, con);


                cmd.Parameters.AddWithValue(
                    "@FullName",
                    txtName.Text
                );

                cmd.Parameters.AddWithValue(
                    "@Email",
                    txtEmail.Text
                );

                cmd.Parameters.AddWithValue(
                    "@Mobile",
                    txtMobile.Text
                );

                cmd.Parameters.AddWithValue(
                    "@Gender",
                    txtGender.Text
                );

                cmd.Parameters.AddWithValue(
                    "@Address",
                    txtAddress.Text
                );

                cmd.Parameters.AddWithValue(
                    "@PatientId",
                    patientId
                );


                con.Open();

                cmd.ExecuteNonQuery();

                con.Close();
            }


            // Exit Edit Mode

            gvPatients.EditIndex = -1;

            LoadPatients();


            Response.Write(
                "<script>alert('Patient Updated Successfully');</script>"
            );
        }


        // =========================================
        // DELETE
        // =========================================

        protected void gvPatients_RowDeleting(
            object sender,
            GridViewDeleteEventArgs e)
        {
            int patientId =
                Convert.ToInt32(
                    gvPatients.DataKeys[e.RowIndex].Value
                );


            using (SqlConnection con =
                   new SqlConnection(cs))
            {
                string query =
                    "DELETE FROM Patients WHERE PatientId=@PatientId";


                SqlCommand cmd =
                    new SqlCommand(query, con);


                cmd.Parameters.AddWithValue(
                    "@PatientId",
                    patientId
                );


                con.Open();

                cmd.ExecuteNonQuery();

                con.Close();
            }


            // Refresh GridView

            LoadPatients();


            Response.Write(
                "<script>alert('Patient Deleted Successfully');</script>"
            );
        }
    }
}




