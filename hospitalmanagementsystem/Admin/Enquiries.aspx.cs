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
    public partial class Enquiries : System.Web.UI.Page
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
                fillEnquiries();
            }
        }
        void getcon()
        {
            con = new SqlConnection(s);
            con.Open();
        }
        void fillEnquiries()
        {
            da = new SqlDataAdapter("Select * from Enquiries order by EnquiryId desc", con);
            ds = new DataSet();
            da.Fill(ds);
            GridViewEnquiries.DataSource = ds;
            GridViewEnquiries.DataBind();
        }
        void clear()
        {
            txtName.Text = "";
            txtEmail.Text = "";
            txtMobile.Text = "";
            txtSubject.Text = "";
            txtMessage.Text = "";
        }
        protected void btnAddEnquiry_Click(object sender, EventArgs e)
        {
            getcon();
            cmd = new SqlCommand("insert into Enquiries(Name,Email,Mobile,Subject,Message) values('" + txtName.Text + "','" + txtEmail.Text + "','" + txtMobile.Text + "','" + txtSubject.Text + "','" + txtMessage.Text + "')", con);
            cmd.ExecuteNonQuery();
            clear();
            fillEnquiries();
            Response.Write("Enquiry Added Successfully");
        }
        protected void btnClear_Click(object sender, EventArgs e)
        {
            clear();
        }
        protected void GridViewEnquiries_RowCommand(object sender, GridViewCommandEventArgs e)
        {
            int id = Convert.ToInt32(e.CommandArgument);
            if (e.CommandName == "DeleteEnquiry")
            {
                getcon();
                cmd = new SqlCommand("Delete from Enquiries where EnquiryId='" + id + "'", con);
                cmd.ExecuteNonQuery();
                fillEnquiries();
                Response.Write("Enquiry Deleted Successfully");
            }
        }
    }
}