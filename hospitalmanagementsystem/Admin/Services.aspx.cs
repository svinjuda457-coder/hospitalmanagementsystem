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
    public partial class Services : System.Web.UI.Page
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
                fillServices();
            }
        }

        void getcon()
        {
            con = new SqlConnection(s);
            con.Open();
        }

        void fillServices()
        {
            da = new SqlDataAdapter("Select * from Services order by ServiceId desc", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewServices.DataSource = ds;
            GridViewServices.DataBind();
        }

        void clear()
        {
            txtServiceName.Text = "";
            txtDescription.Text = "";
        }

        protected void btnAddService_Click(object sender, EventArgs e)
        {
            getcon();
            cmd = new SqlCommand("insert into Services(ServiceName,Description) values('" + txtServiceName.Text + "','" + txtDescription.Text + "')", con);
            cmd.ExecuteNonQuery();
            clear();
            fillServices();
            Response.Write("Service Added Successfully");
        }

        protected void btnClear_Click(object sender, EventArgs e)
        {
            clear();
        }

        protected void GridViewServices_RowCommand(object sender, GridViewCommandEventArgs e)
        {
            int id = Convert.ToInt32(e.CommandArgument);

            if (e.CommandName == "DeleteService")
            {
                getcon();
                cmd = new SqlCommand("Delete from Services where ServiceId='" + id + "'", con);
                cmd.ExecuteNonQuery();
                fillServices();
                Response.Write("Service Deleted Successfully");
            }
            if (e.CommandName == "EditService")
            {
                Response.Redirect("~/ServiceEdit.aspx?id=" + id);
            }
        }
    }
}