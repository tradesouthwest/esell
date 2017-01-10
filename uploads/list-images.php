
<div class="container">
<?php
function countFolder($dir) {
    $get = (count(scandir($dir)) - 2);
        if ($get == -2) {
                $get = 0;
        }
        return $get;
}
?>	<p><?php esc(countFolder('.')); ?>  - Total images uploaded (might include other files).  </p>
    <h5>Directory Contents</h5>
    <style>.hidden{display:none;}</style>
<?php
    if(isset($_GET['delete'])){
        $delurl=$_GET['delete'];
        unlink($delurl);
esc( "file removed from directory" );
    }
?>
    <table class="table table-condensed sortable" style="font-size:87.5%;">
      <thead>
        <tr>
          <th>Filename</th>
		  <th>!Remove</th>
          <th>Type</th>
          <th>Size <small>(bytes)</small></th>
          <th>Date Modified</th>
          <th>View</th>
        </tr>
      </thead>
      <tbody>
<?php
        // Opens directory
        $myDirectory=opendir(".");

        // Gets each entry
        while($entryName=readdir($myDirectory)) {
          $dirArray[]=$entryName;
        }

        // Finds extensions of files
        function findexts ($filename) {
          $filename=strtolower($filename);
          $exts=split("[/\\.]", $filename);
          $n=count($exts)-1;
          $exts=$exts[$n];
          return $exts;
        }

        // Closes directory
        closedir($myDirectory);

        // Counts elements in array
        $indexCount=count($dirArray);

        // Sorts files
        sort($dirArray);

        // Loops through the array of files
        for($index=0; $index < $indexCount; $index++) {

          // Allows ./?hidden to show hidden files
          if($_SERVER['QUERY_STRING']=="hidden")
          {$hide="";
          $ahref="./";
          $atext="Hide";}
          else
          {$hide=".";
          $ahref="./?hidden";
          $atext="Show";}
          if(substr("$dirArray[$index]", 0, 1) != $hide) {

          // Gets File Names
          $name=$dirArray[$index];
          $namehref=$dirArray[$index];

          // Gets Extensions
          $extn=findexts($dirArray[$index]);

          // Gets file size
          $size= number_format(filesize($dirArray[$index]));

          // Gets Date Modified Data
          $modtime=date("M j Y g:i A", filemtime($dirArray[$index]));
          $timekey=date("YmdHis", filemtime($dirArray[$index]));

          // Prettifies File Types, add more to suit your needs.
          switch ($extn){
            case "png": $extn="PNG Image"; break;
            case "jpg": $extn="JPG Image"; break;
			case "jpeg": $extn="JPEG Image"; break;
            case "svg": $extn="SVG Image"; break;
            case "gif": $extn="GIF Image"; break;
            case "mp3": $extn="Media File"; break;

            case "txt": $extn="Text File"; break;
            case "log": $extn="Log File"; break;
            case "htm": $extn="HTML File"; break;
            case "php": $extn="PHP Script"; break;
            case "js": $extn="Javascript"; break;
            case "css": $extn="Stylesheet"; break;
            case "pdf": $extn="PDF Document"; break;

            case "zip": $extn="ZIP Archive"; break;
            case "bak": $extn="Backup File"; break;

            default: $extn=strtoupper($extn)." File"; break;
          }

          // Separates directories
          if(is_dir($dirArray[$index])) {
            $extn="&lt;Directory&gt;";
            $size="&lt;Directory&gt;";
            $class="hidden";
          } else {
            $class="file";
          }

          // Cleans up . and .. directories
          if($name=="."){$name=". (Current Directory)"; $extn="&lt;System Dir&gt;";}
          if($name==".."){$name=".. (Parent Directory)"; $extn="&lt;System Dir&gt;";}
if($name=="image-list.php"){$name=""; $extn="php"; $class="hidden";}
if($name=="list-images.php"){$name=""; $extn="php"; $class="hidden";}
if($name=="index.php"){$name=""; $extn="php"; $class="hidden";}

          // Print 'em
          print("
          <tr class='$class'>
            <td style=\"padding:1px\"><a href='$namehref'>$name</a></td>
			<td><a href=\"?delete=$name\"> [-] </a></td>
            <td style=\"padding:1px\"><a href='$namehref'>$extn</a></td>
            <td style=\"padding:1px\"><a href='$namehref'>$size</a></td>
            <td sorttable_customkey='$timekey' style=\"padding:1px\"><a href='$namehref'>$modtime</a></td>
<td style=\"padding:1px\"><a href=\"".$name."\"  onclick=\"window.open(this.href, 'mywin',
'width=500,height=500,toolbar=1,resizable=0'); return false;\"><img src=\"".$name."\" height=\"30\" /></a></td>
          </tr>");
          }
        }
      ?>
      </tbody>
    </table>
  <h2><?php //print("<a href='$ahref'>$atext hidden files</a>"); ?></h2>

  </div>
