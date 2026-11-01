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
    public partial class Patients : System.Web.UI.Page
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
                fillPatients();
            }
        }

        void getcon()
        {
            con = new SqlConnection(s);
            con.Open();
        }

        void fillPatients()
        {
            da = new SqlDataAdapter("Select * from Registration order by Id desc", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewPatients.DataSource = ds;
            GridViewPatients.DataBind();
        }

        protected void GridViewPatients_RowCommand(object sender, GridViewCommandEventArgs e)
        {
            int id = Convert.ToInt32(e.CommandArgument);

            if (e.CommandName == "DeletePatient")
            {
                getcon();
                cmd = new SqlCommand("Delete from Registration where Id='" + id + "'", con);
                cmd.ExecuteNonQuery();
                fillPatients();
                Response.Write("Patient Deleted Successfully");
            }
            if (e.CommandName == "EditPatient")
            {
                Response.Redirect("~/Registration.aspx?id=" + id);
            }
        }
    }
}