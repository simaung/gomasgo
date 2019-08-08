<!-- Breadcrumb -->
<ol class="breadcrumb">
  <li><a href="<?=base_url()?>home">Home</a></li>
  <li><a href="<?=base_url()?>transaksi">Transaksi</a></li>
  <li class="active">Sales Poin</li>
</ol>

<div class="row">
  
  <div class="col-md-6">  
    <div class="card">
      <div class="card-header">
        <div class="media">
          <div class="media-body media-middle">
            <h6 class="card-title m-b-0"><i class="sidebar-menu-icon material-icons">chrome_reader_mode</i> Sales Poin Anda</h6>
          </div>
        </div>
      </div>
      <table id="DataBonus" class="table table-striped table-hover table-sm">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Nilai</th>
          </tr>
        </thead>
        <tbody>
          <?php $tpoin=0; $trp=0; for($g=1;$g<=10;$g++): $field="poin_group".$g; ?>
            <tr>
              <td>Poin Group <?=$g?></td>
              <td><?=$bonus[0]->$field?></td>
            </tr>
            <?php $nilaiRp = $this->Mgeneral->getValue('setting_value',array('setting_group'=>"sales poin",'setting_name'=>"group ".$g),"setting"); ?>
            <?php 
              $tpoin=$tpoin+$bonus[0]->$field; 
              $nilai=$bonus[0]->$field*$nilaiRp;
              $trp=$trp+$nilai;
            ?>
          <?php endfor; ?>
        </tbody>
        <tfoot>
          <tr>
            <th>Total Poin</th>
            <th><?=$tpoin?></th>
          </tr>
          <tr>
            <th>Nilai Rupiah</th>
            <th><?=int_to_rupiah($trp)?></th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  <div class="col-md-6">  
    <div class="card">
      <div class="card-header">
        <div class="media">
          <div class="media-body media-middle">
            <h6 class="card-title m-b-0"><i class="material-icons text-muted-light">info_outline</i> Keterangan</h6>
          </div>
        </div>
      </div>
      <div class="card-block">
        <p>Dibawah ini daftar konversi setiap poin dari masing-masing group.</p>
        <table id="KonversiBonus" class="table table-striped table-hover table-sm">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Nilai</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($set as $s): ?>
            <tr>
              <td><?=ucfirst($s->setting_name)?></td>
              <td><?=int_to_rupiah($s->setting_value)?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        </table>
      </div>
  </div>

</div>
