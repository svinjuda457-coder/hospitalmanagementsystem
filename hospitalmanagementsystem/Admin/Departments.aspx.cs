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
    public partial class Departments : System.Web.UI.Page
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
                fillDepartments();
            }
        }

        void getcon()
        {
            con = new SqlConnection(s);
            con.Open();
        }

        void fillDepartments()
        {
            da = new SqlDataAdapter("Select * from Departments order by DepartmentId desc", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewDepartments.DataSource = ds;
            GridViewDepartments.DataBind();
        }

        void clear()
        {
            txtDepartmentName.Text = "";
            txtDescription.Text = "";
        }

        protected void btnAddDepartment_Click(object sender, EventArgs e)
        {
            getcon();
            cmd = new SqlCommand("insert into Departments(DepartmentName,Description) values('" + txtDepartmentName.Text + "','" + txtDescription.Text + "')", con);
            cmd.ExecuteNonQuery();
            clear();
            fillDepartments();
            Response.Write("Department Added Successfully");
        }

        protected void btnClear_Click(object sender, EventArgs e)
        {
            clear();
        }

        protected void GridViewDepartments_RowCommand(object sender, GridViewCommandEventArgs e)
        {
            int id = Convert.ToInt32(e.CommandArgument);

            if (e.CommandName == "DeleteDepartment")
            {
                getcon();
                cmd = new SqlCommand("Delete from Departments where DepartmentId='" + id + "'", con);
                cmd.ExecuteNonQuery();
                fillDepartments();
                Response.Write("Department Deleted Successfully");
            }
            if (e.CommandName == "EditDepartment")
            {
                Response.Redirect("~/DepartmentEdit.aspx?id=" + id);
            }
        }
    }
}