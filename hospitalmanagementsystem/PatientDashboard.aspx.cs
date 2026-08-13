using System;

namespace Hospital_Management_System_01
{
    public partial class PatientDashboard : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (Session["PatientId"] == null)
            {
                Response.Redirect("Login.aspx");
                return;
            }

            if (!IsPostBack)
            {
                lblPatientName.Text =
                    Session["PatientName"].ToString();
            }
        }
    }
}