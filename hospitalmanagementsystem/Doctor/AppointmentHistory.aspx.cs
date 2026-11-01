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
    public partial class AppointmentHistory : System.Web.UI.Page
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

            con = new SqlConnection(s);
            con.Open();

            if (!IsPostBack)
            {
                da = new SqlDataAdapter("Select * from Appointments", con);
                ds = new DataSet();
                da.Fill(ds);
                GridViewHistory.DataSource = ds;
                GridViewHistory.DataBind();
            }
        }

        protected void GridViewHistory_RowEditing(object sender, GridViewEditEventArgs e)
        {
            GridViewHistory.EditIndex = e.NewEditIndex;

            con = new SqlConnection(s);
            da = new SqlDataAdapter("Select * from Appointments", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewHistory.DataSource = ds;
            GridViewHistory.DataBind();
        }

        protected void GridViewHistory_RowCancelingEdit(object sender, GridViewCancelEditEventArgs e)
        {
            GridViewHistory.EditIndex = -1;

            con = new SqlConnection(s);
            da = new SqlDataAdapter("Select * from Appointments", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewHistory.DataSource = ds;
            GridViewHistory.DataBind();
        }

        protected void GridViewHistory_RowUpdating(object sender, GridViewUpdateEventArgs e)
        {
            int appId = Convert.ToInt32(GridViewHistory.DataKeys[e.RowIndex].Value);

            GridViewRow row = GridViewHistory.Rows[e.RowIndex];

            TextBox txtPName = (TextBox)row.Cells[1].Controls[0];
            TextBox txtDName = (TextBox)row.Cells[2].Controls[0];
            TextBox txtDept = (TextBox)row.Cells[3].Controls[0];
            TextBox txtDate = (TextBox)row.Cells[4].Controls[0];
            TextBox txtTime = (TextBox)row.Cells[5].Controls[0];
            TextBox txtStatus = (TextBox)row.Cells[6].Controls[0];

            con = new SqlConnection(s);
            con.Open();

            string query = "Update Appointments set PatientName='" + txtPName.Text + "', DoctorName='" + txtDName.Text + "', Department='" + txtDept.Text + "', AppointmentDate='" + txtDate.Text + "', AppointmentTime='" + txtTime.Text + "', Status='" + txtStatus.Text + "' where AppointmentId=" + appId;

            cmd = new SqlCommand(query, con);
            cmd.ExecuteNonQuery();

            GridViewHistory.EditIndex = -1;

            da = new SqlDataAdapter("Select * from Appointments", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewHistory.DataSource = ds;
            GridViewHistory.DataBind();
        }

        protected void GridViewHistory_RowDeleting(object sender, GridViewDeleteEventArgs e)
        {
            int appId = Convert.ToInt32(GridViewHistory.DataKeys[e.RowIndex].Value);

            con = new SqlConnection(s);
            con.Open();

            string query = "Delete from Appointments where AppointmentId=" + appId;

            cmd = new SqlCommand(query, con);
            cmd.ExecuteNonQuery();

            da = new SqlDataAdapter("Select * from Appointments", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewHistory.DataSource = ds;
            GridViewHistory.DataBind();
        }
    }
}
