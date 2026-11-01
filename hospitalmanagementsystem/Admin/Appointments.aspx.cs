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
    public partial class Appointments : System.Web.UI.Page
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
                fillAppointments();
            }
        }

        void getcon()
        {
            con = new SqlConnection(s);
            con.Open();
        }

        void fillAppointments()
        {
            da = new SqlDataAdapter("Select * from Appointments order by AppointmentId desc", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewAppointments.DataSource = ds;
            GridViewAppointments.DataBind();
        }

        protected void GridViewAppointments_RowCommand(object sender, GridViewCommandEventArgs e)
        {
            int id = Convert.ToInt32(e.CommandArgument);

            if (e.CommandName == "DeleteAppointment")
            {
                getcon();
                cmd = new SqlCommand("Delete from Appointments where AppointmentId='" + id + "'", con);
                cmd.ExecuteNonQuery();
                fillAppointments();
            }
            if (e.CommandName == "EditAppointment")
            {
                Response.Redirect("~/AppointmentEdit.aspx?id=" + id);
            }
        }
    }
}