//using System;
//using System.Configuration;
//using System.Data.SqlClient;

//namespace Hospital_Management_System_01
//{
//    public partial class Login : System.Web.UI.Page
//    {
//        string cs = ConfigurationManager
//            .ConnectionStrings["HospitalDBConnectionString"]
//            .ConnectionString;


//        protected void Page_Load(object sender, EventArgs e)
//        {

//        }


//        protected void btnLogin_Click(object sender, EventArgs e)
//        {
//            string email = txtLoginEmail.Text.Trim();
//            string password = txtLoginPassword.Text.Trim();


//            using (SqlConnection con = new SqlConnection(cs))
//            {
//                string query = @"SELECT PatientId, FullName
//                                 FROM Patients
//                                 WHERE Email = @Email
//                                 AND Password = @Password";


//                SqlCommand cmd =
//                    new SqlCommand(query, con);


//                cmd.Parameters.AddWithValue(
//                    "@Email",
//                    email
//                );

//                cmd.Parameters.AddWithValue(
//                    "@Password",
//                    password
//                );


//                con.Open();


//                SqlDataReader dr = cmd.ExecuteReader();


//                if (dr.Read())
//                {
//                    Session["PatientId"] =
//                        dr["PatientId"].ToString();

//                    Session["PatientName"] =
//                        dr["FullName"].ToString();


//                    Response.Redirect("PatientDashboard.aspx");
//                }
//                else
//                {
//                    Response.Write(
//                        "<script>alert('Invalid Email or Password');</script>"
//                    );
//                }


//                dr.Close();
//            }
//        }
//    }
//}
using System;
using System.Configuration;
using System.Data.SqlClient;

namespace Hospital_Management_System_01
{
    public partial class Login : System.Web.UI.Page
    {
        string cs = ConfigurationManager
            .ConnectionStrings["HospitalDBConnectionString"]
            .ConnectionString;


        protected void Page_Load(object sender, EventArgs e)
        {

        }


        protected void btnLogin_Click(object sender, EventArgs e)
        {
            string email = txtLoginEmail.Text.Trim();
            string password = txtLoginPassword.Text.Trim();


            // =========================================
            // ADMIN LOGIN
            // =========================================

            if (email == "admin@gmail.com" &&
                password == "admin123")
            {
                Session["AdminEmail"] = email;
                Session["UserType"] = "Admin";

                Response.Redirect("AdminDashboard.aspx");

                return;
            }


            // =========================================
            // PATIENT LOGIN
            // =========================================

            using (SqlConnection con = new SqlConnection(cs))
            {
                string query = @"
                    SELECT PatientId, FullName, Email
                    FROM Patients
                    WHERE Email = @Email
                    AND Password = @Password";


                SqlCommand cmd = new SqlCommand(query, con);


                cmd.Parameters.AddWithValue(
                    "@Email",
                    email
                );

                cmd.Parameters.AddWithValue(
                    "@Password",
                    password
                );


                con.Open();


                SqlDataReader dr = cmd.ExecuteReader();


                if (dr.Read())
                {
                    // Patient ID
                    Session["PatientId"] =
                        dr["PatientId"].ToString();


                    // Registered Patient Name
                    Session["PatientName"] =
                        dr["FullName"].ToString();


                    // Patient Email
                    Session["PatientEmail"] =
                        dr["Email"].ToString();


                    // User Type
                    Session["UserType"] =
                        "Patient";


                    dr.Close();


                    // Patient Dashboard
                    Response.Redirect("PatientDashboard.aspx");

                    return;
                }


                dr.Close();
            }


            // =========================================
            // INVALID LOGIN
            // =========================================

            Response.Write(
                "<script>alert('Invalid Email or Password');</script>"
            );
        }
    }
}