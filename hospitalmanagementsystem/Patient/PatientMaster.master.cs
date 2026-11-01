using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace Hospital_Management_System_01.Patient
{
    public partial class PatientMaster : System.Web.UI.MasterPage
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (Session["patient"] == null)
            {
                Response.Redirect("~/Login.aspx");
            }
        }
    }
}