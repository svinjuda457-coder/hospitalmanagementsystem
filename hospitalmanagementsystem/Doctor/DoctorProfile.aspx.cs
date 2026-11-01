//using System;
//using System.Collections.Generic;
//using System.Linq;
//using System.Web;
//using System.Web.UI;
//using System.Web.UI.WebControls;

////New Namespace

//using System.Data.SqlClient; //For Connection
//using System.Data;           //For DataSet
//using System.Configuration;  //For connection string

//namespace Hospital_Management_System_01.Doctor
//{
//    public partial class DoctorProfile : System.Web.UI.Page
//    {
//        SqlConnection con; //For connection
//        SqlCommand cmd;    //For insert,update,Delete
//        SqlDataAdapter da; //For Container
//        DataSet ds;        //For Select

//        string s = ConfigurationManager.ConnectionStrings["dbcon"].ConnectionString;

//        protected void Page_Load(object sender, EventArgs e)
//        {
//            if (Session["doctor"] == null)
//            {
//                Response.Redirect("~/Login.aspx");
//            }
//            getcon();
//            if (!IsPostBack)
//            {
//                fillprofile();
//            }
//        }

//        void getcon()
//        {
//            con = new SqlConnection(s);
//            con.Open();
//        }

//        void fillprofile()
//        {
//            da = new SqlDataAdapter("Select * from Doctors where Email = '" + Session["doctor"].ToString() + "'", con);
//            ds = new DataSet();
//            da.Fill(ds);

//            if (ds.Tables[0].Rows.Count > 0)
//            {
//                txtDoctorName.Text = ds.Tables[0].Rows[0]["DoctorName"].ToString();
//                txtEmail.Text = ds.Tables[0].Rows[0]["Email"].ToString();
//                txtMobile.Text = ds.Tables[0].Rows[0]["Mobile"].ToString();
//                txtGender.Text = ds.Tables[0].Rows[0]["Gender"].ToString();
//                txtSpecialization.Text = ds.Tables[0].Rows[0]["Specialization"].ToString();
//            }
//        }

//        protected void btnUpdate_Click(object sender, EventArgs e)
//        {
//            getcon();
//            cmd = new SqlCommand("Update Doctors set DoctorName='" + txtDoctorName.Text + "',Mobile='" + txtMobile.Text + "',Gender='" + txtGender.Text + "',Specialization='" + txtSpecialization.Text + "' where Email='" + Session["doctor"].ToString() + "'", con);
//            cmd.ExecuteNonQuery();
//            Response.Write("Profile Updated Successfully");
//        }
//    }
//}

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
    public partial class DoctorProfile : System.Web.UI.Page
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
                txtEmail.ReadOnly = true;
                fillprofile();
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

        void fillprofile()
        {
            da = new SqlDataAdapter("Select * from Doctors where Email = '" + Session["doctor"].ToString() + "'", con);
            ds = new DataSet();
            da.Fill(ds);

            if (ds.Tables[0].Rows.Count > 0)
            {
                txtDoctorName.Text = ds.Tables[0].Rows[0]["DoctorName"].ToString();
                txtEmail.Text = ds.Tables[0].Rows[0]["Email"].ToString();
                txtMobile.Text = ds.Tables[0].Rows[0]["Mobile"].ToString();
                txtGender.Text = ds.Tables[0].Rows[0]["Gender"].ToString();
                txtSpecialization.Text = ds.Tables[0].Rows[0]["Specialization"].ToString();
            }
        }

        protected void btnUpdate_Click(object sender, EventArgs e)
        {
            getcon();
            cmd = new SqlCommand("Update Doctors set DoctorName='" + txtDoctorName.Text + "',Mobile='" + txtMobile.Text + "',Gender='" + txtGender.Text + "',Specialization='" + txtSpecialization.Text + "' where Email='" + Session["doctor"].ToString() + "'", con);
            cmd.ExecuteNonQuery();

            fillprofile();

            lblMessage.Text = "Profile Updated Successfully";
        }
    }
}
