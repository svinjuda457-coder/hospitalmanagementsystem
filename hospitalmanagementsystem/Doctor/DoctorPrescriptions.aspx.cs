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
    public partial class DoctorPrescriptions : System.Web.UI.Page
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
                DisplayPrescriptions();
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

        void clear()
        {
            txtPatientName.Text = "";
            txtMedicine.Text = "";
            txtDosage.Text = "";
            txtInstructions.Text = "";
        }

        protected void btnSave_Click(object sender, EventArgs e)
        {
            Getcon();
            cmd = new SqlCommand("insert into Prescriptions(PatientName,Medicine,Dosage,Instructions) values('" + txtPatientName.Text + "','" + txtMedicine.Text + "','" + txtDosage.Text + "','" + txtInstructions.Text + "')", con);
            cmd.ExecuteNonQuery();
            clear();
            DisplayPrescriptions();
        }

        void DisplayPrescriptions()
        {
            da = new SqlDataAdapter("Select * from Prescriptions", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewPrescriptions.DataSource = ds;
            GridViewPrescriptions.DataBind();
        }

        protected void GridViewPrescriptions_RowEditing(object sender, GridViewEditEventArgs e)
        {
            GridViewPrescriptions.EditIndex = e.NewEditIndex;
            DisplayPrescriptions();
        }

        protected void GridViewPrescriptions_RowCancelingEdit(object sender, GridViewCancelEditEventArgs e)
        {
            GridViewPrescriptions.EditIndex = -1;
            DisplayPrescriptions();
        }

        protected void GridViewPrescriptions_RowUpdating(object sender, GridViewUpdateEventArgs e)
        {
            int prId = Convert.ToInt32(GridViewPrescriptions.DataKeys[e.RowIndex].Value);

            GridViewRow row = GridViewPrescriptions.Rows[e.RowIndex];

            TextBox tName = (TextBox)row.Cells[1].Controls[0];
            TextBox tMed = (TextBox)row.Cells[2].Controls[0];
            TextBox tDos = (TextBox)row.Cells[3].Controls[0];
            TextBox tInst = (TextBox)row.Cells[4].Controls[0];

            Getcon();
            cmd = new SqlCommand("Update Prescriptions set PatientName='" + tName.Text + "', Medicine='" + tMed.Text + "', Dosage='" + tDos.Text + "', Instructions='" + tInst.Text + "' where PrescriptionId=" + prId, con);
            cmd.ExecuteNonQuery();

            GridViewPrescriptions.EditIndex = -1;
            DisplayPrescriptions();
        }

        protected void GridViewPrescriptions_RowDeleting(object sender, GridViewDeleteEventArgs e)
        {
            int prId = Convert.ToInt32(GridViewPrescriptions.DataKeys[e.RowIndex].Value);

            Getcon();
            cmd = new SqlCommand("Delete from Prescriptions where PrescriptionId=" + prId, con);
            cmd.ExecuteNonQuery();

            DisplayPrescriptions();
        }
    }
}
