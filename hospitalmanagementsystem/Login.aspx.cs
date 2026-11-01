using System;
using System.Web.UI;
using System.Web.UI.WebControls;

//New Namespace
using System.Data.SqlClient; //For Connection
using System.Data;           //For DataSet
using System.Configuration;  //For connection string

namespace Hospital_Management_System_01
{
    public partial class Login : System.Web.UI.Page
    {
        SqlConnection con; //For connection
        SqlCommand cmd;    //For insert,update,Delete
        SqlDataAdapter da; //For Container
        DataSet ds;        //For Select

        int i;

        string s = ConfigurationManager.ConnectionStrings["dbcon"].ConnectionString;
         protected void Page_Load(object sender, EventArgs e)
        {
            getcon();
        }

        void getcon()
        {
            con = new SqlConnection(s);
            con.Open();
        }

        protected void btnLogin_Click(object sender, EventArgs e)
        {
            if (!(string.IsNullOrEmpty(txtLoginEmail.Text)) && !(string.IsNullOrEmpty(txtLoginPassword.Text)))
            {
                // Admin Check
                cmd = new SqlCommand("Select count(*) from Users where Email = '" + txtLoginEmail.Text + "' and Password = '" + txtLoginPassword.Text + "' and Role = 'Admin'", con);
                i = Convert.ToInt16(cmd.ExecuteScalar());

                if (i > 0)
                {
                    Session["admin"] = txtLoginEmail.Text;
                    Response.Redirect("~/Admin/AdminDashboard.aspx");
                }
                else
                {
                    // Doctor Check
                    cmd = new SqlCommand("Select count(*) from Users where Email = '" + txtLoginEmail.Text + "' and Password = '" + txtLoginPassword.Text + "' and Role = 'Doctor'", con);
                    i = Convert.ToInt16(cmd.ExecuteScalar());

                    if (i > 0)
                    {
                        Session["doctor"] = txtLoginEmail.Text;
                        Response.Redirect("~/Doctor/DoctorDashboard.aspx");
                    }
                    else
                    {
                        // Patient Check
                        cmd = new SqlCommand("Select count(*) from Users where Email = '" + txtLoginEmail.Text + "' and Password = '" + txtLoginPassword.Text + "' and Role = 'Patient'", con);
                        i = Convert.ToInt16(cmd.ExecuteScalar());

                        if (i > 0)
                        {
                            Session["patient"] = txtLoginEmail.Text;
                            Response.Redirect("~/Patient/PatientDashboard.aspx");
                        }
                        else
                        {
                            Response.Write("Invalid Email and Password");
                        }
                    }
                }
            }
        }
    }
}