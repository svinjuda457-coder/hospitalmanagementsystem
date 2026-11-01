//using System;
//using System.Web.UI;
//using System.Web.UI.WebControls;
//using System.Data.SqlClient;
//using System.Data;
//using System.Configuration;

//namespace Hospital_Management_System_01
//{
//    public partial class Registration : System.Web.UI.Page
//    {

//        SqlConnection con;
//        SqlCommand cmd;
//        SqlDataAdapter da;
//        DataSet ds;
//        string fnm;

//        string s = ConfigurationManager.ConnectionStrings["dbcon"].ConnectionString;

//        void getCon()
//        {
//            con = new SqlConnection(s);
//            con.Open();
//        }

//        void fillGrid()
//        {
//            getCon();

//            da = new SqlDataAdapter(
//                "select * from dbo.Registration", con);

//            ds = new DataSet();
//            da.Fill(ds);

//            GridView1.DataSource = ds;
//            GridView1.DataBind();

//            con.Close();
//        }

//        void fillData()
//        {
//            getCon();

//            da = new SqlDataAdapter(
//                "select * from Registration where Id='" +
//                ViewState["id"] + "'", con);

//            ds = new DataSet();
//            da.Fill(ds);

//            if (ds.Tables[0].Rows.Count > 0)
//            {
//                txtnm.Text =
//                    ds.Tables[0].Rows[0]["Name"].ToString();

//                rbdgndr.SelectedValue = ds.Tables[0].Rows[0]["Gender"].ToString();
//                txteml.Text = ds.Tables[0].Rows[0]["Email"].ToString();
//                txtct.Text = ds.Tables[0].Rows[0]["City"].ToString();
//                txtAddress.Text = ds.Tables[0].Rows[0]["Address"].ToString();
//                txtMobile.Text = ds.Tables[0].Rows[0]["Mobile"].ToString();
//            }

//            con.Close();
//        }

//        public void clear()
//        {
//            txtnm.Text = string.Empty;
//            txtAddress.Text = string.Empty;
//            txteml.Text = string.Empty;
//            txtMobile.Text = string.Empty;
//            txtct.Text = string.Empty;

//            rbdgndr.SelectedIndex = -1;
//        }

//        protected void Page_Load(object sender, EventArgs e)
//        {
//            if (!IsPostBack)
//            {
//                fillGrid();
//            }
//        }

//        protected void btnRegister_Click(object sender, EventArgs e)
//        {
//            if (btnRegister.Text == "Register")
//            {
//                getCon();

//                cmd = new SqlCommand(
//                    "insert into Registration " +
//                    "(Name,Gender,Email,City,Address,Mobile) " +
//                    "values(@Name,@Gender,@Email,@City,@Address,@Mobile)",
//                    con);

//                cmd.Parameters.AddWithValue("@Name", txtnm.Text);
//                cmd.Parameters.AddWithValue("@Gender", rbdgndr.SelectedValue);
//                cmd.Parameters.AddWithValue("@Email", txteml.Text);
//                cmd.Parameters.AddWithValue("@City", txtct.Text);
//                cmd.Parameters.AddWithValue("@Address", txtAddress.Text);
//                cmd.Parameters.AddWithValue("@Mobile", txtMobile.Text);

//                cmd.ExecuteNonQuery();

//                con.Close();

//                fillGrid();

//                Response.Write("<script>alert('Data Inserted Successfully');</script>");

//                clear();
//            }
//            else
//            {
//                getCon();

//                cmd = new SqlCommand("update Registration set " + "Name=@Name," + "Gender=@Gender," + "Email=@Email," + "City=@City," +  "Address=@Address," + "Mobile=@Mobile " + "where Id=@Id", con);
//                cmd.Parameters.AddWithValue("@Name", txtnm.Text);
//                cmd.Parameters.AddWithValue("@Gender", rbdgndr.SelectedValue);
//                cmd.Parameters.AddWithValue("@Email", txteml.Text);
//                cmd.Parameters.AddWithValue("@City", txtct.Text);
//                cmd.Parameters.AddWithValue("@Address", txtAddress.Text);
//                cmd.Parameters.AddWithValue("@Mobile", txtMobile.Text);
//                cmd.Parameters.AddWithValue("@Id", ViewState["id"]);

//                cmd.ExecuteNonQuery();

//                con.Close();

//                fillGrid();
//                clear();

//                Response.Write("<script>alert('Data Updated Successfully');</script>");

//                btnRegister.Text = "Register";
//            }
//        }

//        // -------------------------------------------------------
//        // GridView1_RowCommand
//        // -------------------------------------------------------
//        protected void Gridview1_RowCommand(object sender,GridViewCommandEventArgs e)
//        {
//            if (e.CommandName == "cmd_edit")
//            {
//                int id = Convert.ToInt32(e.CommandArgument);

//                ViewState["id"] = id;

//                btnRegister.Text = "Update";

//                fillData();
//            }
//            else if (e.CommandName == "cmd_delete")
//            {
//                getCon();

//                cmd = new SqlCommand("delete from Registration where Id=@Id",con);
//                cmd.Parameters.AddWithValue("@Id", e.CommandArgument);

//                cmd.ExecuteNonQuery();

//                con.Close();

//                fillGrid();

//                Response.Write("<script>alert('Data Deleted Successfully');</script>");
//            }
//        }
//    }
//}


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
    public partial class Registration : System.Web.UI.Page
    {
        SqlConnection con; //For connection
        SqlCommand cmd;    //For insert,update,Delete
        SqlDataAdapter da; //For Container
        DataSet ds;        //For Select

        string s = ConfigurationManager.ConnectionStrings["dbcon"].ConnectionString;

        protected void Page_Load(object sender, EventArgs e)
        {
            getcon();
            if (!IsPostBack)
            {
                fillgrid();
            }
        }

        void getcon()
        {
            con = new SqlConnection(s);
            con.Open();
        }

        void fillgrid()
        {
            da = new SqlDataAdapter("Select * from Registration", con);
            ds = new DataSet();
            da.Fill(ds);
            GridView1.DataSource = ds;
            GridView1.DataBind();
        }

        void clear()
        {
            txtnm.Text = "";
            txtMobile.Text = "";
            txtAddress.Text = "";
            txteml.Text = "";
            txtct.Text = "";
            rbdgndr.ClearSelection();
        }

        protected void btnRegister_Click(object sender, EventArgs e)
        {
            getcon();

            cmd = new SqlCommand("insert into Registration(Name,Email,Password,Mobile,Address,Gender) values('" + txtnm.Text + "','" + txteml.Text + "','" + txtct.Text + "','" + txtMobile.Text + "','" + txtAddress.Text + "','" + rbdgndr.SelectedValue + "')", con);
            cmd.ExecuteNonQuery();

            clear();
            fillgrid();
            Response.Write("Patient Registered Successfully");
        }

        protected void Gridview1_RowCommand(object sender, GridViewCommandEventArgs e)
        {

        }
    }
}