using System;

namespace Hospital_Management_System_01
{
    public partial class AdminLogin : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
        }

        protected void btnLogin_Click(object sender, EventArgs e)
        {
            string email = txtEmail.Text.Trim();
            string password = txtPassword.Text.Trim();

            // Admin Email & Password
            if (email == "admin@gmail.com" && password == "admin123")
            {
                // Create Admin Session
                Session["AdminEmail"] = email;

                // Open Admin Dashboard
                Response.Redirect("AdminDashboard.aspx");
            }
            else
            {
                lblMessage.Text = "Invalid Admin Email or Password!";
            }
        }
    }
}