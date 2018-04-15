?using System;
using System.Collections.Generic;
using System.Data;
using System.Data.OleDb;
using System.IO;
using System.Linq;
using System.Windows.Forms;



namespace BasicExcelTextMiner
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            string fileFullPath = Environment.CurrentDirectory + @"\comments.xls";
            List<CommentRecord> commentRecords = GetRecords(fileFullPath);

            var bugs = commentRecords.Where(r => r.CommentText.ToLower().Contains("general: "));

            int count = bugs.Count();

        }
        

        public List<CommentRecord> GetRecords(string fileFullPath)
        {
            List<CommentRecord> records = new List<CommentRecord>();

            try
            {
                OleDbConnection con = null;


                if (Path.GetExtension(fileFullPath) == ".xls")
                    con = new OleDbConnection("Provider=Microsoft.Jet.OLEDB.4.0; Data Source=" + fileFullPath + "; Extended Properties= \"Excel 8.0;HDR=Yes;IMEX=2\"");
                else if (Path.GetExtension(fileFullPath) == ".xlsx")
                    con = new OleDbConnection(@"Provider=Microsoft.ACE.OLEDB.12.0; Data Source=" + fileFullPath + "; Extended Properties='Excel 12.0;HDR=YES;IMEX=1;';");
                                
                con.Open();

                if (con.State == ConnectionState.Open)
                {
                    records = ExtractCommentRecordExcel(con);
                    con.Close();
                }
            }
            catch (Exception ex)
            {
                throw ex;
            }
            return records;
        }
        

        private List<CommentRecord> ExtractCommentRecordExcel(OleDbConnection con)
        {
            DataSet dsCommentRecordInfo = new DataSet();
            OleDbCommand cmd = new OleDbCommand("SELECT * FROM [Sheet4$]", con); //Excel Sheet Name ( CommentRecord )
            OleDbDataAdapter adapter = new OleDbDataAdapter(cmd);

            adapter.Fill(dsCommentRecordInfo, "CommentRecords");

            var dsCommentRecordInfoList = dsCommentRecordInfo.Tables[0].AsEnumerable().Select(s => new CommentRecord
            {
                CommentRecordID = s[0].ToString(),
                CommentText     = s[1].ToString()
            }).ToList();

            return dsCommentRecordInfoList;
        }
        
        public class CommentRecord
        {
            public string CommentRecordID { get; set; }
            public string CommentText { get; set; }
        }
    }
}