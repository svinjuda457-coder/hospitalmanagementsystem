using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Data.SqlClient;
using System.Data;
using System.Configuration;

namespace Hospital_Management_System_01.Doctor
{
    public partial class DoctorPatients : System.Web.UI.Page
    {
        SqlConnection con;
        SqlCommand cmd;
        SqlDataAdapter da;
        DataSet ds;

        string s = ConfigurationManager.ConnectionStrings["dbcon"].ConnectionString;

        protected void Page_Load(object sender, EventArgs e)
        {
            if (Session["doctor"] == null)
            {
                Response.Redirect("~/Login.aspx");
            }
            Getcon();
            if (!IsPostBack)
            {
                DisplayPatients();
            }
        }

        void Getcon()
        {
            con = new SqlConnection(s);
            if (con.State == ConnectionState.Closed)
            {
                con.Open();
            }
        }

        void DisplayPatients()
        {
            da = new SqlDataAdapter("Select PatientId, PatientName, Email, Mobile from Patients", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewPatients.DataSource = ds;
            GridViewPatients.DataBind();
        }

        protected void GridViewPatients_RowEditing(object sender, GridViewEditEventArgs e)
        {
            GridViewPatients.EditIndex = e.NewEditIndex;
            DisplayPatients();
        }

        protected void GridViewPatients_RowCancelingEdit(object sender, GridViewCancelEditEventArgs e)
        {
            GridViewPatients.EditIndex = -1;
            DisplayPatients();
        }

        protected void GridViewPatients_RowUpdating(object sender, GridViewUpdateEventArgs e)
        {
            int pId = Convert.ToInt32(GridViewPatients.DataKeys[e.RowIndex].Value);

            string pName = ((TextBox)GridViewPatients.Rows[e.RowIndex].Cells[1].Controls[0]).Text;
            string pEmail = ((TextBox)GridViewPatients.Rows[e.RowIndex].Cells[2].Controls[0]).Text;
            string pMobile = ((TextBox)GridViewPatients.Rows[e.RowIndex].Cells[3].Controls[0]).Text;

            Getcon();
            cmd = new SqlCommand("Update Patients set PatientName='" + pName + "', Email='" + pEmail + "', Mobile='" + pMobile + "' where PatientId=" + pId, con);
            cmd.ExecuteNonQuery();

            GridViewPatients.EditIndex = -1;
            DisplayPatients();
        }

        protected void GridViewPatients_RowDeleting(object sender, GridViewDeleteEventArgs e)
        {
            int pId = Convert.ToInt32(GridViewPatients.DataKeys[e.RowIndex].Value);

            Getcon();
            cmd = new SqlCommand("Delete from Patients where PatientId=" + pId, con);
            cmd.ExecuteNonQuery();

            DisplayPatients();
        }
    }
}
