using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

//New Namespace

using System.Data.SqlClient; //For Connection
using System.Data;           //For DataSet
using System.Configuration;  //For connection string

namespace Hospital_Management_System_01
{
    public partial class Doctors : System.Web.UI.Page
    {
        SqlConnection con; //For connection
        SqlCommand cmd;    //For insert,update,Delete
        SqlDataAdapter da; //For Container
        DataSet ds;        //For Select

        string s = ConfigurationManager.ConnectionStrings["dbcon"].ConnectionString;

        protected void Page_Load(object sender, EventArgs e)
        {
            if (Session["admin"] == null)
            {
                Response.Redirect("~/Login.aspx");
            }
            getcon();
            if (!IsPostBack)
            {
                fillDoctors();
            }
        }

        void getcon()
        {
            con = new SqlConnection(s);
            con.Open();
        }

        void fillDoctors()
        {
            da = new SqlDataAdapter("Select * from Doctors order by DoctorId desc", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewDoctors.DataSource = ds;
            GridViewDoctors.DataBind();
        }

        void clear()
        {
            txtDoctorName.Text = "";
            ddlGender.SelectedIndex = 0;
            txtEmail.Text = "";
            txtMobile.Text = "";
            txtSpecialization.Text = "";
        }

        protected void btnAddDoctor_Click(object sender, EventArgs e)
        {
            getcon();
            cmd = new SqlCommand("insert into Doctors(DoctorName,Gender,Email,Mobile,Specialization) values('" + txtDoctorName.Text + "','" + ddlGender.SelectedValue + "','" + txtEmail.Text + "','" + txtMobile.Text + "','" + txtSpecialization.Text + "')", con);
            cmd.ExecuteNonQuery();
            clear();
            fillDoctors();
            Response.Write("Doctor Added Successfully");
        }

        protected void btnClear_Click(object sender, EventArgs e)
        {
            clear();
        }

        protected void GridViewDoctors_RowCommand(object sender, GridViewCommandEventArgs e)
        {
            int id = Convert.ToInt32(e.CommandArgument);

            if (e.CommandName == "DeleteDoctor")
            {
                getcon();
                cmd = new SqlCommand("Delete from Doctors where DoctorId='" + id + "'", con);
                cmd.ExecuteNonQuery();
                fillDoctors();
                Response.Write("Doctor Deleted Successfully");
            }
            if (e.CommandName == "EditDoctor")
            {
                Response.Redirect("~/DoctorEdit.aspx?id=" + id);
            }
        }
    }
}