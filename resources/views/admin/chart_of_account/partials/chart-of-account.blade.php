<style>
    /* .tree {
        min-height: 20px;
        padding: 19px;
        margin-bottom: 20px;
        background-color: #ffffff;
        border: 1px solid #ececec;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05)
    } */
    .tree li {
        list-style-type: none;
        margin: 0;
        padding: 10px 5px 0 5px;
        position: relative
    }
    .tree li::before,
    .tree li::after {
        content: '';
        left: -20px;
        position: absolute;
        right: auto
    }
    .tree li::before {
        border-left: 1px solid #ececec;
        bottom: 50px;
        height: 100%;
        top: 0;
        width: 1px
    }
    .tree li::after {
        border-top: 1px solid #ececec;
        height: 20px;
        top: 25px;
        width: 25px
    }
    .tree li span {
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border: 1px solid #ececec;
        border-radius: 5px;
        display: inline-block;
        padding: 3px 8px;
        text-decoration: none
    }
    .tree li.parent_li>span {
        cursor: pointer
    }
    .tree>ul>li::before,
    .tree>ul>li::after {
        border: 0
    }
    .tree li:last-child::before {
        height: 30px
    }
    .tree li.parent_li>span:hover,
    .tree li.parent_li>span:hover+ul li span {
        /* background: #eee;
        border: 1px solid #e0e6f0;
        color: #000 */
    }
    .tree a:hover {
        background-color: lightgray;
    }
    #treeViewHeader span {
        cursor: pointer;
    }
</style>
<div id="treeViewHeader" class="d-flex justify-content-between flex-wrap">
    <h5>รายการบัญชี</h5>
    <div>
        <span class="text-primary">ย่อ</span>/<span class="text-primary">ขยาย</span>
    </div>
    <input type="search" name="search" class="form-control" placeholder="ค้นหารายการบัญชี" onsearch="searchTreeView()">
</div>
<div id="treeView" class="tree well">
    @foreach ($accountClasses as $accClass)
        <li>
            <span class="bg-custom"><i class="icon-folder-open"></i> {{ $accClass['name'] }}</span>
            <ul>
                @foreach ($accClass['primaries'] as $primary)
                <li>
                    <span><i class="icon-minus-sign"></i> {{ $primary['name'] }}</span>
                    <ul>
                        @foreach ($primary['secondaries'] as $secondary)
                        <li>
                            <span><i class="icon-leaf"></i>{{ $secondary['name'] }}</span>
                            <ul>
                                @foreach ($secondary['account_codes'] as $accountCode)
                                <li>
                                    <a href="{{ route('chart_of_account.index', ['id' => $accountCode['id']]) }}" 
                                        class="btn btn-link btn-sm text-dark">
                                        {{ $accountCode['account_code'] }} - {{ $accountCode['name'] }}
                                    </a>
                                </li>    
                                @endforeach
                            </ul>
                        </li>    
                        @endforeach
                    </ul>
                </li>
                @endforeach
            </ul>
        </li>
    @endforeach
</div>

<div id="searchResult" class="tree well d-none">
    <ul class="pl-2">
        @foreach ($accountCodes as $account)
        <li data-id="{{ $account->account_code.$account->name_th }}">
            <a href="{{ route('chart_of_account.index', ['id' => $account->id]) }}" 
                class="btn btn-link btn-sm text-dark">
                {{ $account->account_code }} - {{ $account->name_th }}
            </a>
        </li>        
        @endforeach
    </ul>
</div>