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
    public partial class DoctorAppointments : System.Web.UI.Page
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
            getcon();
            if (!IsPostBack)
            {
                DisplayAppointments();
            }
        }

        void getcon()
        {
            con = new SqlConnection(s);
            if (con.State == ConnectionState.Closed)
            {
                con.Open();
            }
        }

        void DisplayAppointments()
        {
            da = new SqlDataAdapter("Select * from Appointments", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewAppointments.DataSource = ds;
            GridViewAppointments.DataBind();
        }

        protected void GridViewAppointments_RowEditing(object sender, GridViewEditEventArgs e)
        {
            GridViewAppointments.EditIndex = e.NewEditIndex;
            DisplayAppointments();
        }

        protected void GridViewAppointments_RowCancelingEdit(object sender, GridViewCancelEditEventArgs e)
        {
            GridViewAppointments.EditIndex = -1;
            DisplayAppointments();
        }

        protected void GridViewAppointments_RowUpdating(object sender, GridViewUpdateEventArgs e)
        {
            int appId = Convert.ToInt32(GridViewAppointments.DataKeys[e.RowIndex].Value);

            GridViewRow row = GridViewAppointments.Rows[e.RowIndex];

            TextBox txtPName = (TextBox)row.Cells[1].Controls[0];
            TextBox txtDName = (TextBox)row.Cells[2].Controls[0];
            TextBox txtDept = (TextBox)row.Cells[3].Controls[0];
            TextBox txtDate = (TextBox)row.Cells[4].Controls[0];
            TextBox txtTime = (TextBox)row.Cells[5].Controls[0];
            TextBox txtStatus = (TextBox)row.Cells[6].Controls[0];

            string query = "Update Appointments set PatientName='" + txtPName.Text + "', DoctorName='" + txtDName.Text + "', Department='" + txtDept.Text + "', AppointmentDate='" + txtDate.Text + "', AppointmentTime='" + txtTime.Text + "', Status='" + txtStatus.Text + "' where AppointmentId=" + appId;

            getcon();
            cmd = new SqlCommand(query, con);
            cmd.ExecuteNonQuery();

            GridViewAppointments.EditIndex = -1;
            DisplayAppointments();
        }

        protected void GridViewAppointments_RowDeleting(object sender, GridViewDeleteEventArgs e)
        {
            int appId = Convert.ToInt32(GridViewAppointments.DataKeys[e.RowIndex].Value);

            string query = "Delete from Appointments where AppointmentId=" + appId;

            getcon();
            cmd = new SqlCommand(query, con);
            cmd.ExecuteNonQuery();

            DisplayAppointments();
        }
    }
}
