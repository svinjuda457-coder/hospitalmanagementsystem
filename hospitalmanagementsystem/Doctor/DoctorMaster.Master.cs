using System;

namespace Hospital_Management_System_01.Doctor
{
    public partial class DoctorMaster : System.Web.UI.MasterPage
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (Session["doctor"] == null)
            {
                Response.Redirect("~/Login.aspx");
            }
        }
    }
}